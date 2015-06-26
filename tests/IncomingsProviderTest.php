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

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }



}