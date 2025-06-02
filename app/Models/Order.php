<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
        'status',
        'payment_method',
        'payment_status',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(
            [
                'name' => 'Guest Customer',
            ]
        );
    }

    public static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = self::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number)  return $number + 1;
        else return $year . '0001';
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }
    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')->where('type', 'billing');
    }
    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')->where('type', 'shipping');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->using(OrderItem::class)
            ->withPivot([
                'quantity',
                'price',
                'product_name',
                'options'
            ]);
    }
}
