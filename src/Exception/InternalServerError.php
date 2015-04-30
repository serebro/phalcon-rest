<?php

namespace PhalconRest\Exception;

use PhalconRest\Http\Response;

class InternalServerError extends AbstractResponse
{
    protected $status_code = Response::INTERNAL_SERVER_ERROR;
}