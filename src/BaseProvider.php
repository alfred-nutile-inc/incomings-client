<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 6/25/15
 * Time: 8:31 PM
 */

namespace AlfredNutileInc\Incomings;

use GuzzleHttp\Client;

abstract class BaseProvider
{


    protected $clean_out = ['PASS', 'KEY', 'SECRET', 'LS_COLORS', 'TOKEN'];
    protected $server;
    protected $payload;

    public $token;

    public $url = 'http://dev.incomings.io';

    protected $full_payload = [];

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    public function send($data = [])
    {
        if (!env('INCOMINGS_TOKEN')) {
            return true;
        }

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
        if (isset($_SERVER['SERVER_NAME'])) {
            return $_SERVER['SERVER_NAME'];
        }

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
        foreach ($this->clean_out as $item) {
            if (stripos($key, $item) !== false) {
                unset($this->server[$key]);
            }
        }

        return false;
    }

    public function sendFullPayload($full_payload)
    {
        try {
            $this->setToken();
            $this->setUrl();
            $this->setFullPayload($full_payload);
            if ($this->token == false) {
                throw new \Exception("Missing your Project TOKEN see readme.md for help");
            }

            $this->curl_post();
        } catch (\Exception $e) {
            //@TODO must use direct log bypass incomings else loops here
            //Log::debug(sprintf("Error sending post to Incoming API %s", $e->getMessage()));
        }
    }

    //@codingStandardsIgnoreStart
    protected function curl_post(array $options = array())
    {
        //@codingStandardsIgnoreEnd
        try {
            $response = $this->getClient()->post($this->getFullUrl(), [
                'body' => json_encode($this->getFullPayload(), JSON_PRETTY_PRINT)
            ]);

            return $response->getStatusCode();
        } catch (\Exception $e) {
            //Nothing to do here
            //@TODO log no response but use file logger
            dd($e->getMessage());
        }
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
        if ($url == false) {
            $url = getenv('INCOMINGS_URL');
        }
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
        if ($token == false) {
            $token = getenv('INCOMINGS_TOKEN');
        }

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
        foreach ($this->server as $key => $value) {
            $this->inCleaner($key);
        }
    }

    public function getClient()
    {
        if (!$this->client) {
            $this->setClient();
        }

        return $this->client;
    }

    public function setClient($client = null)
    {
        if (!$client) {
            $client = new Client();
        }

        $this->client = $client;
    }
}
