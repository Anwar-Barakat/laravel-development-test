<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $request->only(['user_id', 'products', 'price', 'payment_id']);
        $validation = Validator::make($data, [
            "user_id"       => ['required', 'integer', 'min:1'],
            "products"      => ['required', 'array'],
            "products.*"    => ['required', 'integer', 'min:1'],
            "payment_id"    => ['required', 'integer', 'min:1'],
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

        if (!in_array($data['payment_id'], Payment::pluck('id')->toArray())) :
            return response()->json([
                'status'    => false,
                'message'   => 'payment type not found',
            ], 401);
        endif;

        $order  = Order::create($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Order Has Been Created Successfully',
            'order'     => new OrderResource($order)
        ], 201);
    }
}
