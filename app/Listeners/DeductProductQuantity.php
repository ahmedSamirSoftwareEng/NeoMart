<?php

namespace App\Listeners;

use App\Events\OrderCreated;


class DeductProductQuantity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        foreach ($order->products as $product) {
            $product->decrement('quantity', $product->pivot->quantity);
            // Product::where('id', $item->product_id)
            //     ->update([
            //         'quantity' => DB::raw('quantity - ' . $item->quantity)
            //     ]);
        }
    }
}
