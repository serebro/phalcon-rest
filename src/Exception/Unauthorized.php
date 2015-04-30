<?php

namespace PhalconRest\Exception;

use PhalconRest\Http\Response;

class Unauthorized extends AbstractResponse
{
    protected $status_code = Response::UNAUTHORIZED;
}