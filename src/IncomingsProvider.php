<?php


namespace AlfredNutileInc\Incomings;


class IncomingsProvider extends BaseProvider
{

    protected $clean_out = ['PASS', 'KEY', 'SECRET', 'LS_COLORS'];
    protected $server;
    protected $payload;

    public function send($data = [])
    {
        $this->getAndSetServer();
        $this->setPayload($data);

        $this->sendFullPayload([
                'headers' => [],
                'payload' => $this->getPayload(),
                'server'  => $this->getServer()
        ]);

        return true;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function setServer($server)
    {
        $this->server = $server;
        return $this;
    }

    private function getAndSetServer()
    {
        $this->server = $_SERVER;

        $this->transformServer();
    }

    public function transformServer()
    {
        foreach($this->server as $key => $value)
        {
            $this->inCleaner($key);
        }
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    private function inCleaner($key)
    {
        foreach($this->clean_out as $item)
        {
            if(stripos($key, $item) !== false)
            {
                unset($this->server[$key]);
            }
        }

        return false;
    }
}