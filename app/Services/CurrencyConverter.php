<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;
    private $baseUrl = 'http://api.exchangeratesapi.io/v1';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function convert(string $from, string $to, float $amount = 1): float
    {
        $response = Http::baseUrl($this->baseUrl)
            ->get('/latest', [
                'access_key' => $this->apiKey,
                'symbols' => "$from,$to"
            ]);
        if (!$response->successful()) {
            throw new \Exception("API request failed: " . $response->body());
        }

        $rates = $response->json()['rates'] ?? [];

        if (!isset($rates[$from]) || !isset($rates[$to])) {
            throw new \Exception("Missing rates for currencies: $from or $to");
        }

        $calcuatedAmount = $amount * ($rates[$from] / $rates[$to]);

        return round($calcuatedAmount, 2);
    }
}
