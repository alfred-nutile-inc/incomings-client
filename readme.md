# Laravel and Non-Laravel Library To Connect to Incomings Service

![logo](https://dl.dropboxusercontent.com/s/fz0zwwsxawlyj8t/logo_wide.jpeg?dl=0)

## Install

Composer install

~~~
composer require alfred-nutile-inc/incomings-client
~~~

Add to app.php

~~~
'AlfredNutileInc\Incomings\IncomingsServiceProvider',
~~~

Set in your .env

INCOMINGS_URL=http://dev.incomings.io

INCOMINGS_TOKEN=token_of_project


## Send Data to the Service

### URL

This is the most simple helper. Each project gets on

![url](https://dl.dropboxusercontent.com/s/7tw1cgu5wvlgz10/Screenshot%202015-06-25%2019.22.04.png?dl=0)

So you can for example use that on Iron.io as a PUSH queue route since you can have more than one.

Or even on your server setup a cron job to post every minute your server resource status or security status.

Example Iron.io

![iron](https://dl.dropboxusercontent.com/s/h3q4ojcbmg22ts6/iron_example.png?dl=0)

### Laravel Facade

Say you are about to send off to a queue

~~~
Queue::push("foo", $data);
~~~

Now try

~~~
$data = ['title' => 'Foo Bar', 'message' => [1,2,3]]

Incomings::send($data);

Queue::push("foo", $data);
~~~



For the above Facade to work you might have to add

~~~
use AlfredNutileInc\Incomings\IncomingsFacade as Incomings;
~~~

### Filter

Coming Soon...

### MiddleWare

Coming Soon...