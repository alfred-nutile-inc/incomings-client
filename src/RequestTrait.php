<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/4/15
 * Time: 8:40 AM
 */

namespace AlfredNutileInc\Incomings;

trait RequestTrait
{

    public $title;


    public function makeMessageFromRequest($request)
    {
        $message['header']      = $request->header();
        $message['ip']          = $request->ip();
        $message['input']       = $request->all();
        $message['json']        = $request->json();
        $message['method']      = $request->method();
        $message['url']         = $request->fullUrl();
        $message['server']      = $request->server();

        return $message;
    }


    public function makeTitle($request)
    {

        if (!$this->title) {
            $this->title = sprintf(" IP %s Method %s URL %s", $request->ip(), $request->method(), $request->fullUrl());
        }

        return $this->title;
    }
}
