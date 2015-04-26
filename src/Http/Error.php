<?php

namespace PhalconRest\Http;

use Exception;

abstract class Error extends Exception
{

    protected $response_data;


    public function __construct($message, $code, array $data = null)
    {
        $this->response_data = [
            'status_code' => $code,
            'message' => $message,
        ];
        if ($data) {
            $this->response_data['data'] = $data;
        }
    }
}
