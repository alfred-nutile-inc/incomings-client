<?php


namespace AlfredNutileInc\Incomings;

use Illuminate\Support\Facades\Facade;

class IncomingsFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'incomings';
    }
}
