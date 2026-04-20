<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends BaseController
{
    /**
     * Store a new order from the app.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'store_id' => 'required|exists:stores,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|string',
            'address' => 'required|string',
            'city' => 'nullable|string',
            'address_id' => 'nullable|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $lat = null;
        $long = null;

        if ($request->filled('address_id')) {
            $addressModel = \App\Models\Address::find($request->address_id);
            if ($addressModel) {
                // Notice the Address migration uses 'lng' for longitude, but order uses 'long'.
                $lat = $addressModel->lat;
                $long = $addressModel->lng; 
            }
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => $request->user_id,
                'store_id' => $request->store_id,
                'address_id' => $request->address_id,
                'total_amount' => $request->total_price,
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'lat' => $lat,
                'long' => $long,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                ]);
            }

            DB::commit();

            return $this->sendResponse($order->load('orderItems'), 'تم استقبال الطلب بنجاح', 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('حدث خطأ أثناء معالجة الطلب.', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get order details by ID for tracking.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $order = Order::with(['orderItems.product', 'store'])->find($id);

        if (!$order) {
            return $this->sendError('لم يتم العثور على بيانات الطلب.', [], 404);
        }

        return $this->sendResponse($order, 'تم جلب بيانات الطلب بنجاح');
    }
}
