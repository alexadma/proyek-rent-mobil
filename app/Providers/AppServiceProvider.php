<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        if ($this->app->environment('production')) {
            config([
                'app.debug' => false,
                'session.secure' => true,
            ]);

            URL::forceScheme('https');
        }

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
