<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            throw new InvalidOrderException();
        }
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }
    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'addr.*.first_name' => 'required|string',
            'addr.*.last_name' => 'required|string',
        ]);
        $items = $cart->get()->groupBy('product.store_id')->all();
        DB::beginTransaction();
        try {
            // create order
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => auth()->check() ? auth()->user()->id : null,
                    'payment_method' => 'cod',
                ]);
            }
            // create order items
            foreach ($cart_items as $item) {
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
                $value['type'] = $type;
                $order->addresses()->create($value);
            }
            DB::commit();
            // event('order.created', $order, Auth::user());
            event(new OrderCreated($order));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('orders.payments.create', $order->id)->with('success', 'Order created successfully.');
    }
}
