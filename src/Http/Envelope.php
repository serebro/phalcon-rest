<?php

namespace PhalconRest\Http;

use Phalcon\Mvc\User\Component;

abstract class Envelope extends Component
{

    const CODE = 0;
    const MSG = 1;

    /** @var array */
    protected $meta = [];

    /** @var string */
    protected $meta_key = 'meta';

    /** @var array */
    protected $data = [];

    /** @var string */
    protected $data_key = 'data';

    /** @var bool */
    protected $disabled = true;


    /**
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param boolean $disabled
     * @return $this
     */
    public function setDisabled($disabled = true)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * @param string $key
     * @param        $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->meta[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return null
     */
    public function get($key)
    {
        return empty($this->meta[$key]) ? null : $this->meta[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->meta);
    }

    /**
     * @param string $key
     * @return $this
     */
    public function remove($key)
    {
        unset($this->meta[$key]);

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param int $value
     * @return Envelope
     */
    public function setTotal($value)
    {
        return $this->set('total', $value);
    }

    /**
     * The number of allowed requests in the current period
     * @param int $value
     * @return Envelope
     */
    public function setRateLimit($value)
    {
        return $this->set('rateLimit', $value);
    }

    /**
     * The number of remaining requests in the current period
     * @param int $value
     * @return Envelope
     */
    public function setRateLimitRemaining($value)
    {
        return $this->set('rateLimitRemaining', $value);
    }

    /**
     * The number of seconds left in the current period
     * @param int $value
     * @return Envelope
     */
    public function setRateLimitReset($value)
    {
        return $this->set('rateLimitReset', $value);
    }

    public function statusCodeOK()
    {
        return $this->set('status', [200, 'OK']);
    }

    public function statusCodeCreated()
    {
        return $this->set('status', [201, 'Created']);
    }

    public function statusCodeAccepted()
    {
        return $this->set('status', [202, 'Accepted']);
    }

    public function statusCodeNoContent()
    {
        return $this->set('status', [204, 'No Content']);
    }

    public function statusCodePartialContent()
    {
        return $this->set('status', [206, 'Partial Content']);
    }

    abstract public function make();
}
