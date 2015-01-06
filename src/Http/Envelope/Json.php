<?php

namespace PhalconRest\Http\Envelope;

use PhalconRest\Http\Envelope;

class Json extends Envelope
{

    public function make()
    {
        if (!$this->has('status')) {
            $this->statusCodeOK();
        }

        $status = $this->get('status');

        if ($this->request->get('suppress_response_codes')) {
            $this->set('response_code', $status[Envelope::CODE]);
            $this->set('message', $status[Envelope::MSG]);
            $this->remove('status');
        }

        if ($this->has('status')) {
            $this->response->setStatusCode($status[Envelope::CODE], $status[Envelope::MSG]);
        }

        if ($this->has('total')) {
            $this->response->setHeader('X-Record-Count', $this->get('total'));
        }

        if ($this->has('rateLimit')) {
            $this->response->setHeader('X-Rate-Limit-Limit', $this->get('rateLimit'));
        }

        if ($this->has('rateLimitRemaining')) {
            $this->response->setHeader('X-Rate-Limit-Remaining', $this->get('rateLimitRemaining'));
        }

        if ($this->has('rateLimitReset')) {
            $this->response->setHeader('X-Rate-Limit-Reset', $this->get('rateLimitReset'));
        }

        return [
            $this->meta_key => $this->meta,
            $this->data_key => $this->data,
        ];
    }
}