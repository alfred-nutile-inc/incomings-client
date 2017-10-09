<?php
namespace AlfredNutileInc\Incomings\Tests;

use AlfredNutileInc\Incomings\IncomingsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function getPackageProviders($app)
    {
        return [IncomingsServiceProvider::class];
    }
}
