<?php namespace AlfredNutileInc\Incomings;

use Illuminate\Support\ServiceProvider;

class IncomingsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('incomings', function($app) {
           return new IncomingsProvider();
        });
    }

    public function providers()
    {
        return ['incomings'];
    }

}