<?php

namespace PhalconRest\Mvc;

use Phalcon\Mvc\Controller;

/**
 * Class RestController
 * @package PhalconRest\Mvc
 */
abstract class RestController extends Controller
{

    /** @var \PhalconRest\Mvc\RestView */
    public $view;

    protected $fields = [];

    protected $sort;

    protected $limit;

    protected $offset;

    protected $method_key = '_method';


    protected function initialize()
    {
        if ($this->request->has($this->method_key)) {
            $method = $this->request->get($this->method_key);
        } else {
            $method = $this->request->getHeader('X-HTTP-Method-Override');
        }

        if (!empty($method)) {
            $this->dispatcher->setActionName($method);
        }

        $this->fields = explode(',', $this->request->get('fields'));
        $this->sort = $this->request->get('sort');
        $this->limit = $this->request->get('limit', 'int', null);
        $this->offset = $this->request->get('offset', 'int', null);
    }
}
