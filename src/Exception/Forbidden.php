<?php

namespace PhalconRest\Exception;

use PhalconRest\Http\Response;

class Forbidden extends AbstractResponse
{
    protected $status_code = Response::FORBIDDEN;
}