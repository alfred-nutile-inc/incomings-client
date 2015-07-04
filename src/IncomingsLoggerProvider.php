<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/4/15
 * Time: 5:52 AM
 */

namespace AlfredNutileInc\Incomings;

use Illuminate\Log\Writer;

class IncomingsLoggerProvider extends BaseProvider {

    /**
     * @var Writer
     */
    protected $logger;

    protected $data_logger;

    protected $data_incomings;

    public function setLogger($logger)
    {
        $this->logger = $logger;

        return $this;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function prepData($data, $level = 'info')
    {
        $this->prepForIncomings($data, $level);
        $this->prepForLogger($data);


    }

    public function debug($data)
    {
        $this->prepData($data, 'debug');

        $this->send($this->data_incomings);

        $this->getLogger()->debug($this->data_logger);
    }

    public function notice($data)
    {
        $this->prepData($data, 'notice');

        $this->send($this->data_incomings);

        $this->getLogger()->notice($this->data_logger);
    }

    public function warning($data)
    {
        $this->prepData($data, 'warning');

        $this->send($this->data_incomings);

        $this->getLogger()->warning($this->data_logger);
    }

    public function info($data)
    {
        $this->prepData($data, 'info');

        $this->send($this->data_incomings);

        $this->getLogger()->info($this->data_logger);
    }


    public function alert($data)
    {
        $this->prepData($data, 'alert');

        $this->send($this->data_incomings);

        $this->getLogger()->alert($this->data_logger);
    }


    public function emergency($data)
    {
        $this->prepData($data, 'emergency');

        $this->send($this->data_incomings);

        $this->getLogger()->emergency($this->data_logger);
    }

    public function error($data)
    {
        $this->prepData($data, 'error');

        $this->send($this->data_incomings);

        $this->getLogger()->error($this->data_logger);
    }

    public function critical($data)
    {
        $this->prepData($data, 'critical');

        $this->send($this->data_incomings);

        $this->getLogger()->critical($this->data_logger);
    }

    private function prepForIncomings($data, $level = 'info')
    {

        if(!is_array($data))
        {
            $this->data_incomings['message']    = $data;
            $this->data_incomings['title']      = sprintf("[%s] %s", strtoupper($level), "Message from Incomings Logger");
        }
        else
        {
            $this->data_incomings = $data;

            $this->prefixIncomingsTitle($level);
        }


        return $this;
    }

    private function prepForLogger($data)
    {
        if(is_array($data) && isset($data['message']))
            $this->data_logger = $data['message'];
        else
            $this->data_logger = print_r($data, 1);

    }

    /**
     * @return mixed
     */
    public function getDataLogger()
    {
        return $this->data_logger;
    }

    /**
     * @param mixed $data_logger
     */
    public function setDataLogger($data_logger)
    {
        $this->data_logger = $data_logger;
    }

    /**
     * @return mixed
     */
    public function getDataIncomings()
    {
        return $this->data_incomings;
    }

    /**
     * @param mixed $data_incomings
     */
    public function setDataIncomings($data_incomings)
    {
        $this->data_incomings = $data_incomings;
    }

    private function prefixIncomingsTitle($level)
    {
        if(isset($this->data_incomings['title']))
        {
            $this->data_incomings['title'] = sprintf("[%s] %s", strtoupper($level), $this->data_incomings['title']);
        }
        else
        {
            $this->data_incomings['title'] = sprintf("[%s] %s", strtoupper($level), "Message from Incomings Logger");
        }
    }

}