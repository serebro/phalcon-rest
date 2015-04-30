<?php

namespace PhalconRest\Exception;

use PhalconRest\Http\Response;

class Locked extends AbstractResponse
{
    protected $status_code = Response::LOCKED;
}