<?php

namespace PhalconRest\Mvc;

use Phalcon\Mvc\Controller;

abstract class RestController extends Controller
{

    protected $fields = [];

    protected $sort;

    protected $limit;

    protected $offset;


    protected function initialize()
    {
        /** @var \Phalcon\Http\RequestInterface $request */
        $request = $this->getDI()->get('request');

        if ($request->has('_method')) {
            $method = $request->get('_method');
        } else {
            $method = $request->getHeader('X-HTTP-Method-Override');
        }

        if (!empty($method)) {
            /** @var \Phalcon\DispatcherInterface $dispatcher */
            $dispatcher = $this->getDI()->get('dispatcher');
            $dispatcher->setActionName($method);
        }

        $this->fields = explode(',', $request->get('fields'));
        $this->sort = $request->get('sort');
        $this->limit = $request->get('limit', 'int');
        $this->offset = $request->get('offset', 'int');
    }

    /**
     * The number of allowed requests in the current period
     * @param int $limit
     * @return $this
     */
    protected function setRateLimit($limit)
    {
        /** @var \Phalcon\Http\Response $response */
        $response = $this->getDI()->get('response');
        $response->setHeader('X-Rate-Limit-Limit', $limit);
        return $this;
    }

    /**
     * The number of remaining requests in the current period
     * @param int $limit
     * @return $this
     */
    protected function setRateLimitRemaining($limit)
    {
        /** @var \Phalcon\Http\Response $response */
        $response = $this->getDI()->get('response');
        $response->setHeader('X-Rate-Limit-Remaining', $limit);
        return $this;
    }

    /**
     * The number of seconds left in the current period
     * @param int $limit
     * @return $this
     */
    protected function setRateLimitReset($limit)
    {
        /** @var \Phalcon\Http\Response $response */
        $response = $this->getDI()->get('response');
        $response->setHeader('X-Rate-Limit-Reset', $limit);
        return $this;
    }
}
