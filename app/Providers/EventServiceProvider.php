<?php

namespace App\Providers;

use App\Events\OrderCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\EmptyCart;
use App\Listeners\DeductProductQuantity;
use App\Listeners\SendOrderCreatedNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // 'order.created' => [
        //     DeductProductQuantity::class,
        //     EmptyCart::class,

        // ],
        OrderCreated::class => [
            DeductProductQuantity::class,
            EmptyCart::class,
            SendOrderCreatedNotification::class
        ]
    ];

    /**
     * Register any events for your application.    
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
