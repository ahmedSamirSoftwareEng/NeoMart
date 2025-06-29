<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\CurrencyConverter;
use Illuminate\Support\Facades\Cache;

class CurrencyConverterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'currency_code' => 'required|string|size:3',
        ]);
        $currencyCode = $request->input('currency_code');
        $baseCurrency = config('app.currency', 'EUR');
        $cacheKey = 'currency_rate' . '_' . $currencyCode;

        $rate = Cache::get($cacheKey, 0);

        if (!$rate) {
            $converter = app('currency.converter');
            $rate = $converter->convert($currencyCode, $baseCurrency);
            Cache::put($cacheKey, $rate, now()->addMinutes(60));
        }

        Session::put('currency_code', $currencyCode);
        return redirect()->back();
    }
}
