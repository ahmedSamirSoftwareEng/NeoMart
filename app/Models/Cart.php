<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $fillable = [
        'cookie_id',
        'user_id',
        'product_id',
        'quantity',
        'options',
    ];

    public static function boot()
    {
        parent::boot();
        static::observe(CartObserver::class);
        // static::creating(function(Cart $cart){
        //     $cart->id = Str::uuid();
        // });
        static::addGlobalScope('cookie', function (Builder $builder) {
            $builder->where('cookie_id', '=', Cart::getCookieId());
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withdefault(
            [
                'name' => 'Anonymous',
            ]
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function getCookieId(): string
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id,  60 * 24 * 30);
        }
        return $cookie_id;
    }
}
