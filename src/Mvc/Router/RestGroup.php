<?php

namespace PhalconRest\Mvc\Router;

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group;

class RestGroup extends Group
{

    /** @var string */
    protected $namespace = '\Controllers\Api';

    /** @var string */
    protected $prefix = '/api';

    /** @var string */
    protected $id_filter = '[0-9]+';


    public function __construct($paths = null)
    {
        parent::__construct($paths);
        $this->setName('PhalconRestDefaultRouter');
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdFilter()
    {
        return $this->id_filter;
    }

    /**
     * @param string $idFilter
     * @return $this
     */
    public function setIdFilter($idFilter)
    {
        $this->id_filter = $idFilter;

        return $this;
    }

    public function initDefault()
    {
        $id_filter = $this->id_filter ? ':' . $this->id_filter : '';
        $this->addOptions('/{controller}', ['action' => 'options', 'namespace' => $this->namespace]);
        $this->addOptions('/{controller}/{id' . $id_filter . '}', ['action' => 'options', 'namespace' => $this->namespace]);
        $this->add('/{controller}/{action}', ['namespace' => $this->namespace]);
        $this->addGet('/{controller}/{id' . $id_filter . '}', ['action' => 'get', 'namespace' => $this->namespace]);
        $this->addPut('/{controller}/{id' . $id_filter . '}', ['action' => 'put', 'namespace' => $this->namespace]);
        $this->addPatch('/{controller}/{id' . $id_filter . '}', ['action' => 'patch', 'namespace' => $this->namespace]);
        $this->addHead('/{controller}/{id' . $id_filter . '}', ['action' => 'head', 'namespace' => $this->namespace]);
        $this->addDelete('/{controller}/{id' . $id_filter . '}', ['action' => 'delete', 'namespace' => $this->namespace]);
        $this->add('/{controller}/{id' . $id_filter . '}/{action}', ['namespace' => $this->namespace]);
        $this->addDelete('/{controller}', ['action' => 'delete', 'namespace' => $this->namespace]);
        $this->addGet('/{controller}', ['action' => 'index', 'namespace' => $this->namespace]);
        $this->addPost('/{controller}', ['action' => 'post', 'namespace' => $this->namespace]);
    }
}
