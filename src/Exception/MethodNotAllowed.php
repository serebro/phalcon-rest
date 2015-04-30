<?php

namespace PhalconRest\Exception;

use PhalconRest\Http\Response;

class MethodNotAllowed extends AbstractResponse
{
    protected $status_code = Response::METHOD_NOT_ALLOWED;
}