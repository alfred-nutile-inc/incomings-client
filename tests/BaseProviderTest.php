<?php
namespace AlfredNutileInc\Incomings\Tests;

use AlfredNutileInc\Incomings\IncomingsProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery as m;

class BaseProviderTest extends TestCase
{

    /**
     * @test
     */
    public function send_returns_true_if_env_not_set()
    {
        $client = m::mock(Client::class)->shouldReceive('post')->never();
        $base = new IncomingsProvider();
        $base->setClient($client);
        $base->send([]);
    }

    /**
     * @test
     */
    public function should_have_env_and_try_to_post()
    {
        $mock = new MockHandler([
            new Response(202, ['Content-Length' => 0]),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        putenv("INCOMINGS_TOKEN=true");
        $base = new IncomingsProvider();
        $base->setClient($client);
        $base->send([]);

        $this->assertEquals(0, $mock->count());
    }

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }
}
