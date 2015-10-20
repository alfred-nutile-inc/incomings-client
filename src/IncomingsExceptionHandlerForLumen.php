<?php namespace AlfredNutileInc\Incomings;

use Exception;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use AlfredNutileInc\Incomings\IncomingsFacade as Incomings;

class IncomingsExceptionHandlerForLumen extends ExceptionHandler {

    /**
     * Code / Idea from BugSnag
     */
    public function report(Exception $e)
    {

        $data = [
            'title' => 'Application Exception Error',
            'message' => sprintf(
                "Error Filename %s \n on line %d \n with message %s \n with Code %s",
                $e->getFile(),
                $e->getLine(),
                $e->getMessage(),
                $e->getCode()
            ),
        ];

        Incomings::send($data);

        return parent::report($e);
    }

}