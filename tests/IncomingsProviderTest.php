<?php

use App\Project;
use Mockery as m;

class IncomingsProviderTest extends \TestCase
{

    /**
     * @test
     */
    public function facade_should_work()
    {
        $this->assertTrue(\AlfredNutileInc\Incomings\IncomingsFacade::send());
    }

    /**
     * @test
     */
    public function should_send_to_client()
    {
        $this->markTestSkipped("Testing locally");

        foreach(range(1, 10) as $index)
        {
            $project = Project::find(1);

            $incoming = m::mock('\AlfredNutileInc\Incomings\IncomingsProvider')->makePartial();

            $incoming->setUrl(env('INCOMINGS_URL'));
            $incoming->setToken($project->token);
            $incoming->send(['foo' => 'bar']);
            sleep(1);
        }


    }

    /**
     * @test
     */
    public function should_build_server_removing_passwords()
    {

        $incoming = m::mock('\AlfredNutileInc\Incomings\IncomingsProvider')->makePartial();

        $server = file_get_contents(__DIR__ . '/fixtures/server.json');

        $server = json_decode($server, true);

        $incoming->setServer($server)->transformServer();

        $this->assertArrayNotHasKey('DB_PASSWORD', $incoming->getServer());
        $this->assertArrayNotHasKey('MAIL_PASSWORD', $incoming->getServer());
        $this->assertArrayNotHasKey('ADMIN_PASS', $incoming->getServer());
    }

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }



}