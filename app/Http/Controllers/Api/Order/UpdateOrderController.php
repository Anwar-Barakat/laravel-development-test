<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        if ($order) {
            $data = $request->only(['products']);

            $validation = Validator::make($data, [
                "products"      => ['required', 'array'],
                "products.*"    => ['required', 'integer'],
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'validation error, please try again',
                    'errors'    => $validation->errors()
                ], 401);
            }

            foreach ($data['products'] as $product_id) :
                $product    = Product::find($product_id);
                if (!$product)
                    return response()->json([
                        'status'    => false,
                        'message'   => 'product not found',
                    ], 401);
            endforeach;

            $order->update(['products' => $data['products']]);

            return response()->json([
                'status'    => true,
                'message'   => 'Order Has Been Updated Successfully',
                'order'     => new OrderResource($order)
            ], 201);
        } else
            return response()->json([
                'status'    => false,
                'message'   => 'not found !!',
            ], 404);
    }
}