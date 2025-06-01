<?php

namespace App\Observers;

use App\Models\Cart;
use ILluminate\Support\Str;

class CartObserver
{

    public function creating(Cart $cart)
    {
        $cart->id = Str::uuid();
        $cart->cookie_id = Cart::getCookieId();
    }

    public function updated(Cart $cart)
    {
        //
    }
    public function deleted(Cart $cart)
    {
        //
    }
    public function restored(Cart $cart)
    {
        //
    }
    public function forceDeleted(Cart $cart)
    {
        //
    }
}
