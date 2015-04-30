<?php

namespace PhalconRest\Exception;

use PhalconRest\Http\Response;

class Conflict extends AbstractResponse
{
    protected $status_code = Response::CONFLICT;
}