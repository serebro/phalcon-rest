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

    protected $fields = [];

    protected $sort;

    protected $limit;

    protected $offset;


    protected function initialize()
    {
        $this->view = $this->getDI()->get('restView');
        $this->fields = explode(',', $this->request->get('fields'));
        $this->sort = $this->request->get('sort');
        $this->limit = $this->request->get('limit', 'int', null);
        $this->offset = $this->request->get('offset', 'int', null);
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
