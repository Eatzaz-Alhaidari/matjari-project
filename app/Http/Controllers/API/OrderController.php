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
            'payment_method' => 'required|in:cash_on_delivery,credit_card,bank_transfer',
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

        $userId = Auth::id() ?? $request->user_id ?? 1; // Fallback
        $items = $request->items;

        // Group items by store_id
        $itemsByStore = [];
        foreach ($items as $itemData) {
            $product = Product::find($itemData['product_id']);

            // Check stock
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
        }

        DB::beginTransaction();
        try {
            $createdOrders = [];

            foreach ($itemsByStore as $storeId => $storeItems) {
                // Calculate total for this store's order
                $totalAmount = 0;
                foreach ($storeItems as $item) {
                    $totalAmount += $item['product']->price * $item['quantity'];
                }

                // Create Order
                $order = Order::create([
                    'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                    'user_id' => $userId,
                    'store_id' => $storeId,
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                    'shipping_address' => $request->shipping_address,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending',
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

                    // Decrement stock
                    $product->decrement('stock', $quantity);
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
