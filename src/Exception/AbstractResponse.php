<?php

namespace PhalconRest\Exception;

use Exception;
use PhalconRest\Http\Response;

abstract class AbstractResponse extends Exception
{

    protected $status_code;


    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        if (is_array($message)) {
            $message = json_encode($message); // todo
        }

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->status_code;
    }

    public function getStatusMessage()
    {
        return Response::$status[$this->status_code];
    }
}