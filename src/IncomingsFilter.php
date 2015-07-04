<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/4/15
 * Time: 8:36 AM
 */

namespace AlfredNutileInc\Incomings;


class IncomingsFilter extends BaseProvider {

    use RequestTrait;

    public function handle($request)
    {
        $this->makeTitle($request);

        $message = $this->makeMessageFromRequest($request);

        $data['title']      = sprintf("[IncomingsMiddleware] %s", $this->title);
        $data['message']    = json_encode($message, JSON_PRETTY_PRINT);

        $this->send($data);

    }
}