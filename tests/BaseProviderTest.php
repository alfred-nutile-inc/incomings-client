<?php
namespace AlfredNutileInc\Incomings\Tests;

use AlfredNutileInc\Incomings\IncomingsProvider;
use GuzzleHttp\Client;
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
        $this->markTestIncomplete("Fixing other bug");
        $client = m::mock(Client::class)
            ->shouldReceive('post')->once()
            ->andReturn([]);
        putenv("INCOMINGS_TOKEN=true");
        $base = new IncomingsProvider();
        $base->setClient($client);
        $base->send([]);
    }

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }
}
