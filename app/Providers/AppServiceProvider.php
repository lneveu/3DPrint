<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('allowed_extension', function($attribute, $value, $parameters, $validator)
        {
            $extension = strtolower($value->getClientOriginalExtension());
            $allowed_extensions_array = array_map('strtolower', $parameters);

            return in_array($extension,$allowed_extensions_array);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
