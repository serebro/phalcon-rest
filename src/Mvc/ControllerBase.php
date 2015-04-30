<?php

namespace PhalconRest\Mvc;

use Phalcon\Mvc\Controller;

/**
 * Class ControllerBase
 * @property \PhalconRest\Mvc\RestView view
 * @package PhalconRest\Mvc
 */
abstract class ControllerBase extends Controller implements RestControllerInterface
{

    /** @var RestView */
    protected $rest;

    /** @var array */
    protected $fields = [];

    /** @var string */
    protected $sort = '';

    /** @var int */
    protected $limit = 50;

    /** @var int */
    protected $offset = 0;


    protected function initialize()
    {
        $fields = $this->request->get('fields', null, null);
        $this->fields = $fields ? explode(',', $fields) : [];
        $this->sort = $this->request->get('sort', null, '');
        $this->limit = $this->request->get('limit', 'int', 50);
        $this->offset = $this->request->get('offset', 'int', 0);

        $this->rest = $this->getDI()->get('rest');
    }

    public function optionsAction()
    {
    }

    public function getAction()
    {
    }

    public function putAction()
    {
    }

    public function patchAction()
    {
    }

    public function headAction()
    {
    }

    public function deleteAction()
    {
    }
}
