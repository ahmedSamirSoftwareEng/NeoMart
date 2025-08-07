<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Order $order)
    {
        return view('front.payments.create', [
            'order' => $order
        ]);
    }

    public function createStripePaymentIntent(Order $order)
    {

        $amount = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        // Initialize a client with just the API key
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => intval(round($amount * 100)),
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        return  [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }

    public function confirm(Request $request, Order $order)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->payment_intent,
        );
        // dd($paymentIntent);
        try {
            if ($paymentIntent->status === 'succeeded') {
                $payment = new Payment();
                $payment->forceFill([
                    'order_id' => $order->id,
                    'amount' => $paymentIntent->amount,
                    'currency' => $paymentIntent->currency,
                    'method' => 'stripe',
                    'status' => 'completed',
                    'transaction_id' => $paymentIntent->id,
                    'transaction_data' => json_encode($paymentIntent),
                ])->save();
            }
        } catch (\QueryException $e) {
            echo $e->getMessage();
            return;
        }
        return redirect()->route('home', ['status' => 'payment-successed']);
    }
    }
