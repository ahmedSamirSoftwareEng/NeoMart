<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = ['database'];
        if ($notifiable->notification_preferences['orderCreated']['mail'] ?? false) {
            $channels[] = 'mail';
        }
        if ($notifiable->notification_preferences['orderCreated']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if ($notifiable->notification_preferences['orderCreated']['broadcast'] ?? false) {
            $channels[] = 'broadcast';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $addr = $this->order->billingAddress;
        return (new MailMessage)
            ->subject('New Order #' . $this->order->number)
            ->greeting("Hello {$notifiable->name}")
            ->line("A new order (# .{$this->order->number} ) created by {$addr->name} form {$addr->countryName}.")
            ->action('View Order', url('/dashboard'))
            ->line('Thank you for using our application!');
    }


    public function toDatabase($notifiable)
    {
        $addr = $this->order->billingAddress;
        return [
            'body' => "A new order (# .{$this->order->number} ) created by {$addr->name} form {$addr->countryName}.",
            "icon" => "fa fa-file",
            "url" => url('/dashboard'),
            "order_id" => $this->order->id
        ];
    }
}
