<?php namespace AlfredNutileInc\Incomings;

use AlfredNutileInc\Incomings\IncomingsLoggerProvider;
use AlfredNutileInc\Incomings\IncomingsProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

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
    }

    public function providers()
    {
        return ['incomings', 'incomings_logger'];
    }
}
