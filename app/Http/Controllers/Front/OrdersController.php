<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function show(Order $order)
    {
        $delivery = $order->delivery()->select([
            'id',
            'order_id',
            'status',
            DB::raw("ST_y(current_location) as lng"),
            DB::raw("ST_x(current_location) as lat"),
        ])
            ->where('order_id', $order->id)
            ->first();

        return view(
            'front.orders.show',
            [
                'order' => $order,
                'delivery' => $delivery
            ]
        );
    }
}
