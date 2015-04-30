<?php

namespace PhalconRest\Exception;

use PhalconRest\Http\Response;

class TooManyRequests extends AbstractResponse
{
    protected $status_code = Response::TOO_MANY_REQUESTS;
}