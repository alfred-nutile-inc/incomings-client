<?php


namespace AlfredNutileInc\Incomings;



use Illuminate\Support\Facades\Facade;

class Log extends Facade
{

    protected static function getFacadeAccessor() { return 'incomings_logger'; }
}