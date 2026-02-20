<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('exists_multi', function ($attribute, $value, $parameters, $validator) {
            foreach ($parameters as $table) {
                if (\DB::table($table)->where($attribute, $value)->exists()) {
                    return true;
                }
            }
            return false;
        });
    }
}
