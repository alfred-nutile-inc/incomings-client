<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 6/25/15
 * Time: 8:31 PM
 */

namespace AlfredNutileInc\Incomings;


use Illuminate\Support\Facades\Log;

abstract class BaseProvider {


    public $token;

    public $url = 'http://dev.incomings.io';

    protected $full_payload = [];

    public function sendFullPayload($full_payload)
    {
        try
        {
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
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
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

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }


    private function getFullUrl()
    {
        return $this->url . '/incomings/' . $this->token;
    }


    protected function getFullPayload()
    {
        return $this->full_payload;
    }


}