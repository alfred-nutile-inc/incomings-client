<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/4/15
 * Time: 6:49 AM
 */

namespace AlfredNutileInc\Incomings;


use Closure;

class IncomingsMiddleWare extends BaseProvider {

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try
        {
            $this->handleIncomings($request, $next);
        }
        catch(\Exception $e)
        {
            Log::info(sprintf("Error getting Incomings", $e->getMessage()));
        }


        return $next($request);
    }

    private function handleIncomings($request, $next)
    {

        $send['title']      = sprintf("[IncomingsMiddleware] %s", $this->makeTitle());
        $send['message']    = $this->makeMessage($request, $next);

    }

    private function makeTitle()
    {
        return 'foo';
    }

    private function makeMessage($request, $next)
    {
        return "foo";
    }

}