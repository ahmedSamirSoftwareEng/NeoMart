<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
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
        $user = User::where('store_id', $event->order->store_id)->first();
        $user->notify(new OrderCreatedNotification($event->order));

        // $users = User::where('store_id', $event->order->store_id)->get();
        // Notification::send($users, new OrderCreatedNotification($event->order));
    }
}
