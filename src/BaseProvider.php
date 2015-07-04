<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 6/25/15
 * Time: 8:31 PM
 */

namespace AlfredNutileInc\Incomings;


abstract class BaseProvider {


    protected $clean_out = ['PASS', 'KEY', 'SECRET', 'LS_COLORS', 'TOKEN'];
    protected $server;
    protected $payload;

    public $token;

    public $url = 'http://dev.incomings.io';

    protected $full_payload = [];

    public function send($data = [])
    {
        if(!getenv('INCOMINGS_TOKEN'))
            return true;

        $this->getAndSetServer();
        $this->setPayload($data);

        $this->sendFullPayload([
            'headers' => [],
            'payload' => $this->getPayload(),
            'server'  => $this->getServer()
        ]);


        return true;
    }

    public function getServerName()
    {
        if(isset($_SERVER['SERVER_NAME']))
            return $_SERVER['SERVER_NAME'];

        return false;
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

    public function sendFullPayload($full_payload)
    {
        try
        {
            $this->setToken();
            $this->setUrl();
            $this->setFullPayload($full_payload);
            if($this->token == false)
                throw new \Exception("Missing your Project TOKEN see readme.md for help");

            $this->curl_post();
        }
        catch(\Exception $e)
        {
            Log::debug(sprintf("Error sending post to Incoming API %s", $e->getMessage()));
        }

    }

    protected function curl_post(array $options = array())
    {

        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $this->getFullUrl(),
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_POSTFIELDS => json_encode($this->getFullPayload(), JSON_PRETTY_PRINT)
        );

        $ch = curl_init();

        curl_setopt_array($ch, ($options + $defaults));

        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }

    /**
     * @param array $full_payload
     */
    public function setFullPayload($full_payload)
    {
        $this->full_payload = $full_payload;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url = false)
    {
        if($url == false)
            $url = getenv('INCOMINGS_URL');
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token = false)
    {
        if($token == false)
            $token = getenv('INCOMINGS_TOKEN');

        $this->token = $token;

        return $this->token;
    }

    private function getFullUrl()
    {
        return $this->url . '/incomings/' . $this->token;
    }


    protected function getFullPayload()
    {
        return $this->full_payload;
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
        $this->server['SERVER_NAME'] = $this->getServerName();
    }

    public function transformServer()
    {
        foreach($this->server as $key => $value)
        {
            $this->inCleaner($key);
        }
    }

}