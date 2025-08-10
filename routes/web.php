<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthentication;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // products
    Route::get('/products',  [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('products.show');
    // cart
    Route::resource('cart', CartController::class);
    // checkout
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store']);


    // 2FA
    Route::get('/auth/user/2fa', [TwoFactorAuthentication::class, 'index'])->name('front.2fa');

    // currency
    Route::post('currency', [CurrencyConverterController::class, 'store'])->name('currency.store');
    // language
    Route::post('language', [HomeController::class, 'language'])->name('language.store');
});

// stripe payment
Route::get('orders/{order}/pay', [PaymentController::class, 'create'])->name('orders.payments.create');
Route::post('orders/{order}/stripe/payment-intent/create', [PaymentController::class, 'createStripePaymentIntent'])->name('stripe.paymentIntent.create');
Route::get('orders/{order}/order/pay/stripe/callback', [PaymentController::class, 'confirm'])->name('stripe.return');
Route::any('stripe/webhook', [StripeWebhookController::class, 'handleStripeWebhook'])->name('stripe.webhook');
// socialite
Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('auth.socialite.callback');
Route::get('auth/{provider}/user', [SocialController::class, 'index'])->name('auth.socialite.user');
require __DIR__ . '/dashboard.php';
// require __DIR__ . '/auth.php';
