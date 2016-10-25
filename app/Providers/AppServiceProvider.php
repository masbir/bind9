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
        $this->customValidators();
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

    public function customValidators()
    {

        \Validator::extend('hostname', function($attribute, $value, $parameters, $validator) { 
            return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $value) //valid chars check
                && preg_match("/^.{1,253}$/", $value) //overall length check
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $value)   ); 
        });

        \Validator::extend('ipv4', function($attribute, $value, $parameters, $validator) { 
            return !filter_var($value, FILTER_VALIDATE_IP) === false; 
        });
    }
}
