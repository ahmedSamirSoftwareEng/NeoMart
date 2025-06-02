<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if($cart->get()->count() == 0) return redirect()->route('home');
        return view('front.checkout', [
            'cart' => $cart,
        ]);
    }
    public function store(Request $request, CartRepository $cart)
    {
        $items = $cart->get()->groupBy('product.store_id')->all();
        DB::beginTransaction();
        try {
            // create order
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => auth()->user()->id,
                    'payment_method' => 'cod',
                ]);
            }
            // create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity
                ]);
            }
            // create order addresses
            foreach ($request->post('addr') as $type => $value) {
                $address['type'] = $type;
                $order->addresses()->create($address);
            }
            $cart->empty();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
