<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id'    => ['required', 'integer'],
        ]);

        if ($validation->fails())
            return response()->json([
                'status'    => false,
                'message'   => 'userId is required, please try again',
                'errors'    => $validation->errors()
            ], 401);

        $order = Order::where('user_id', $request->user_id)->orderBy('id', 'desc')->paginate(5);
        if ($order->count() > 0)
            return response()->json([
                'status'    => true,
                'message'   => 'my orders',
                'orders'    => OrderResource::collection($order)
            ], 200);

        else
            return response()->json([
                'status'    => false,
                'message'   => 'No orders yet !!',
            ], 404);
    }
}
