<?php

namespace PhalconRest\Exception;

use PhalconRest\Http\Response;

class BadRequest extends AbstractResponse
{
    protected $status_code = Response::BAD_REQUEST;
}