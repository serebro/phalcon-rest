<?php

namespace PhalconRest\Http;

use Phalcon\Http\Response as PhalconResponse;

class Response extends PhalconResponse
{

    public function send()
    {
        $request = $this->getDI()->get('request');
        if ($request->get('suppress_response_codes', null, null)) {
            $this->setStatusCode(200, 'OK')->sendHeaders();
        }

        return parent::send();
    }
}
