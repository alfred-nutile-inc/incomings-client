<?php namespace AlfredNutileInc\Incomings;

use Illuminate\Support\ServiceProvider;

class IncomingsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('incomings', function($app) {
           return new IncomingsProvider();
        });

        $this->app->singleton('incomings_logger', function($app) {

            $incomings = new IncomingsLoggerProvider();
            $incomings->setLogger($app['log']);

            return $incomings;
        });
    }

    public function providers()
    {
        return ['incomings', 'incomings_logger'];
    }

}