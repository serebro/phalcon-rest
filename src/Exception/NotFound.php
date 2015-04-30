<?php

namespace PhalconRest\Exception;

use PhalconRest\Http\Response;

class NotFound extends AbstractResponse
{
    protected $status_code = Response::NOT_FOUND;
}