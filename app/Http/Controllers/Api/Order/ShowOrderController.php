<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class ShowOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        if ($order)
            return response()->json([
                'status'    => true,
                'message'   => 'my orders',
                'orders'    => new OrderResource($order)
            ], 200);

        else
            return response()->json([
                'status'    => false,
                'message'   => 'No orders yet !!',
            ], 404);
    }
}
