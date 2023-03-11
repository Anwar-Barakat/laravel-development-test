<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class GetOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $orders     = Order::orderBy('id', 'desc')->paginate(5);
        if ($orders->count() > 0)
            return response()->json([
                'status'    => true,
                'message'   => 'get all orders',
                'orders'    => OrderResource::collection($orders)
            ], 200);
    }
}
