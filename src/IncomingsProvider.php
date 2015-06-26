<?php


namespace AlfredNutileInc\Incomings;


class IncomingsProvider extends BaseProvider
{

    protected $clean_out = ['PASS', 'KEY', 'SECRET', 'LS_COLORS'];
    protected $payload;

    public function send($data = [])
    {
        $this->setPayload($data);

        $this->sendFullPayload($this->getPayload());

        return true;
    }


    public function getPayload()
    {
        return $this->payload;
    }

    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

}