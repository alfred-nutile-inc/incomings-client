<?php

namespace AlfredNutileInc\Incomings;

use Monolog\Logger;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Log\LogManager;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use AlfredNutileInc\Incomings\IncomingsProvider;
use AlfredNutileInc\Incomings\IncomingsLoggerProvider;
use AlfredNutileInc\Incomings\IncomingsMonologHandler;

class IncomingsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('incomings', function ($app) {
            if ($app->environment(['testing'])) {
                $mock = new MockHandler([
                    new Response(200, ['Content-Length' => 0])
                ]);

                $handler = HandlerStack::create($mock);
                $client = new Client(['handler' => $handler]);

                $incomings = new IncomingsProvider();
                $incomings->setClient($client);
                return $incomings;
            }

            return new IncomingsProvider();
        });

        $this->app->singleton('incomings_logger', function ($app) {
            $incomingsLogger = new IncomingsLoggerProvider();
            return $incomingsLogger;
        });

        if ($this->app['log'] instanceof LogManager) {
            $this->app['log']->extend('incomings', function ($app, $config) {
                $logger = new Logger('incomings');
                $logger->pushHandler(new IncomingsMonologHandler());
                return $logger;
            });
        }
    }

    public function providers()
    {
        return ['incomings', 'incomings_logger'];
    }
}
