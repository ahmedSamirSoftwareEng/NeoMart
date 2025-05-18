<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Rules\Filter;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('filter', function ($attribute, $value, $parameters, $validator) {
            $forbiddenWords = $parameters;
            $rule = new Filter($forbiddenWords);
            return $rule->passes($attribute, $value);
        }, 'The :attribute contains forbidden words.');

        Paginator::useBootstrapFour();
    }
}
