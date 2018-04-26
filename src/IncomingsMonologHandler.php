<?php

namespace AlfredNutileInc\Incomings;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class IncomingsMonologHandler extends AbstractProcessingHandler
{
    /**
     * @var AlfredNutileInc\Incomings\IncomingsLoggerProvider
     */
    protected $incomings;

    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->incomings = app('incomings_logger');
    }

    /**
     * Write the log message.
     *
     * @param array $data
     * @return void
     */
    protected function write(array $record)
    {
        $this->send($record);
    }

    /**
     * Send the log to incomings.
     *
     * @param array $data
     * @return void
     */
    protected function send($data)
    {
        $level = strtolower($data['level_name']);
        $this->incomings->$level($data['message']);
    }
}
