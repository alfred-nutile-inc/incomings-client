<?php

namespace AlfredNutileInc\Incomings\Tests;

use Mockery as m;

class IncomingsLoggerTest extends TestCase
{
    /**
     * @test
     */
    public function should_make_incomings_array_from_string_message_and_leave_log_alone()
    {
        $incoming = m::mock('\AlfredNutileInc\Incomings\IncomingsLoggerProvider')->makePartial();
        $incoming->shouldReceive('send');

        $message = "Normal Log Message";

        $incoming->info($message);

        $this->assertEquals('[INFO] Message from Incomings Logger', $incoming->getDataIncomings()['title']);
        $this->assertEquals('Normal Log Message', $incoming->getDataIncomings()['message']);
        $this->assertEquals('Normal Log Message', $incoming->getDataLogger());
    }


    /**
     * @test
     */
    public function should_handle_user_using_array_to_logger()
    {
        $incoming = m::mock('\AlfredNutileInc\Incomings\IncomingsLoggerProvider')->makePartial();
        $incoming->shouldReceive('send');

        $message = [
            'title' => "Using Incomings Logger!",
            'message' => "Normal Log Message"
        ];

        $incoming->info($message);

        $this->assertEquals('[INFO] Using Incomings Logger!', $incoming->getDataIncomings()['title']);
        $this->assertEquals('Normal Log Message', $incoming->getDataIncomings()['message']);
        $this->assertEquals('Normal Log Message', $incoming->getDataLogger());
    }

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }
}
