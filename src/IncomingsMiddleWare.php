<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/4/15
 * Time: 6:49 AM
 */

namespace AlfredNutileInc\Incomings;


use Closure;
use Illuminate\Support\Facades\File;

class IncomingsMiddleWare extends BaseProvider {

    protected $title;

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $title = false)
    {
        $this->title = $title;

        try
        {
            $this->handleIncomings($request, $next);
        }
        catch(\Exception $e)
        {
            Log::info(sprintf("Error getting Incomings %s", $e->getMessage()));
        }


        return $next($request);
    }

    private function handleIncomings($request, $next)
    {

        $this->makeTitle($request);

        $data['title']      = sprintf("[IncomingsMiddleware] %s", $this->title);
        $data['message']    = $this->makeMessage($request, $next);

        $this->send($data);

    }

    private function makeTitle($request)
    {

        if(!$this->title)
        {
            $this->title = sprintf(" IP %s Method %s URL %s", $request->ip(), $request->method(), $request->fullUrl());
        }

        return $this->title;
    }

    private function makeMessage($request, $next)
    {
        $message['header']      = $request->header();
        $message['ip']          = $request->ip();
        $message['input']       = $request->all();
        $message['json']        = $request->json();
        $message['method']      = $request->method();
        $message['url']         = $request->fullUrl();
        $message['server']      = $request->server();
        $message['next']        = json_encode($next, JSON_PRETTY_PRINT);

        return json_encode($message, JSON_PRETTY_PRINT);
    }

}