<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::with(['items.product', 'store:id,name'])
            ->where('user_id', Auth::id() ?? 1) // Fallback for dev/testing if auth missing
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * Handles creating orders, potentially splitting them by store.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cash_on_delivery,wallet,bank_transfer',
            'payment_proof' => 'nullable|required_if:payment_method,bank_transfer|image|max:2048', // Image required for transfer
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user() ?? \App\Models\User::find($request->user_id ?? 1); // Use authenticated user
        $items = $request->items;

        // Group items by store_id
        $itemsByStore = [];
        $grandTotal = 0; // Total of ALL orders for wallet check

        // 1. Validate Stock & Calculate Totals
        foreach ($items as $itemData) {
            $product = Product::find($itemData['product_id']);

            if ($product->stock < $itemData['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Product {$product->name} is out of stock or insufficient quantity.",
                ], 400);
            }

            $itemsByStore[$product->store_id][] = [
                'product' => $product,
                'quantity' => $itemData['quantity']
            ];
            $grandTotal += $product->price * $itemData['quantity'];
        }

        // 2. Wallet Balance Check
        if ($request->payment_method === 'wallet') {
            $wallet = $user->wallet; // Assuming relationship is setup
            if (!$wallet || $wallet->balance < $grandTotal) {
                return response()->json([
                    'success' => false,
                    'message' => "رصيد المحفظة غير كافي لإتمام هذه العملية.",
                ], 400);
            }
        }

        DB::beginTransaction();
        try {
            $createdOrders = [];

            // Payment Proof Upload
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            foreach ($itemsByStore as $storeId => $storeItems) {
                // Calculate total for this store's order
                $orderTotal = 0;
                foreach ($storeItems as $item) {
                    $orderTotal += $item['product']->price * $item['quantity'];
                }

                // Create Order
                $order = Order::create([
                    'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                    'user_id' => $user->id,
                    'store_id' => $storeId,
                    'total_amount' => $orderTotal,
                    'status' => 'pending',
                    'shipping_address' => $request->shipping_address,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending', // Default pending
                    'payment_proof' => $paymentProofPath,
                    'notes' => $request->notes,
                ]);

                // Create Order Items and Update Stock
                foreach ($storeItems as $item) {
                    $product = $item['product'];
                    $quantity = $item['quantity'];
                    $price = $product->price;
                    $lineTotal = $price * $quantity;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $lineTotal,
                    ]);

                    $product->decrement('stock', $quantity);
                }

                try {
                    $service = new \App\Services\OnyxService();
                    $result = $service->createOrder([
                        'type' => 'SO',
                        'storeOrderId' => $order->order_number,
                        'mobile' => $user->phone ?? '967777777777', // Use user phone or fallback
                        'OrderDetailsList' => array_map(function ($item) {
                            return [
                                'product_id' => $item['product']->id,
                                'quantity' => $item['quantity'],
                                'price' => $item['product']->price
                            ];
                        }, $storeItems)
                    ]);

                    if (isset($result['success']) && $result['success'] && isset($result['onyx_ref'])) {
                        $order->update(['onyx_ref' => $result['onyx_ref']]);
                    }

                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('OnyxService Error: ' . $e->getMessage());
                    // Continue order creation even if Onyx fails? Assuming yes.
                }

                // 5. Handle Payment
                if ($request->payment_method == 'wallet') {
                    app(\App\Services\PaymentService::class)->payWithWallet($user, $orderTotal, $order);
                } elseif ($request->payment_method == 'credit_card') {
                    if (!$request->has('payment_token')) {
                        throw new \Exception('يرجى إدخال بيانات البطاقة بشكل صحيح.');
                    }

                    // Charge Stripe
                    $stripeService = app(\App\Services\StripeService::class);
                    $charge = $stripeService->charge($orderTotal, $request->payment_token, 'USD'); // Assuming USD for now

                    // Log Transaction
                    \Illuminate\Support\Facades\DB::table('transactions')->insert([
                        'user_id' => $user->id,
                        'order_id' => $order->id,
                        'transaction_id' => $charge->id,
                        'provider' => 'stripe',
                        'amount' => $orderTotal,
                        'currency' => 'USD',
                        'status' => 'success',
                        'payload' => json_encode($charge),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $order->update(['payment_status' => 'paid', 'status' => 'processing']);
                }

                $createdOrders[] = $order->load('items');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order(s) created successfully.',
                'data' => $createdOrders
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $userId = Auth::id() ?? 1;
        $order = Order::with(['items.product', 'store', 'shipment']) // Load shipment details if any
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found or access denied.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }
}

