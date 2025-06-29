<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Rules\Filter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use App\Services\CurrencyConverter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('currency.converter', function () {
            new CurrencyConverter(config('services.currency_converter.api_key'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        Validator::extend('filter', function ($attribute, $value, $parameters, $validator) {
            $forbiddenWords = $parameters;
            $rule = new Filter($forbiddenWords);
            return $rule->passes($attribute, $value);
        }, 'The :attribute contains forbidden words.');

        Paginator::useBootstrapFour();
    }
}
