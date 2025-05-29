<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use Illuminate\Cache\RetrievesMultipleKeys;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{

    public function get(): collection
    {
        return Cart::where('cookie_id', '=', $this->getCookieId())->all();
    }
    public function add(Product $product, $quantity = 1)
    {
        Cart::create([
            'cookie_id' => $this->getCookieId(),
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);
    }
    public function update(Product $product, $quantity)
    {
        Cart::where('product_id', $product->id)->where('cookie_id', $this->getCookieId())->update(['quantity' => $quantity]);
    }
    public function delete(Product $product)
    {
        Cart::where('product_id', $product->id)->where('cookie_id', $this->getCookieId())->delete();
    }
    public function empty()
    {
        Cart::where('cookie_id', '=', $this->getCookieId())->delete();
    }
    public function total(): float
    {
        return Cart::where('cookie_id', $this->getCookieId())
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('sum(products.price * carts.quantity) as total')
            ->value('total');
    }

    protected function getCookieId(): string
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, Carbon::now()->addDays(30));
        }
        return $cookie_id;
    }
}
