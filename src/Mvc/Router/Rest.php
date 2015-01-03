<?php

namespace PhalconRest\Mvc\Router;

use Phalcon\Mvc\Router\Group;
use Phalcon\Mvc\Router;

class Rest
{

    /** @var Group */
    protected $apiGroup;

    /** @var string */
    protected $namespace = '\Controllers\Api';

    /** @var string */
    protected $prefix = '/api';


    /**
     * @param string $id_regexp
     * @return $this
     */
    public function init($id_regexp = '')
    {
        if ($id_regexp) {
            $id_regexp = ':' . $id_regexp;
        }

        if (empty($this->apiGroup)) {
            $this->apiGroup = new Group();
        }

        $this->apiGroup->setPrefix($this->prefix);
        $this->apiGroup->addOptions('/{controller}', ['action' => 'options', 'namespace' => $this->namespace]);
        $this->apiGroup->addGet    ('/{controller}', ['action' => 'index', 'namespace' => $this->namespace]);
        $this->apiGroup->addPost   ('/{controller}', ['action' => 'post', 'namespace' => $this->namespace]);
        $this->apiGroup->add       ('/{controller}/{action}', ['namespace' => $this->namespace]);
        $this->apiGroup->addOptions('/{controller}/{id' . $id_regexp . '}', ['action' => 'options', 'namespace' => $this->namespace]);
        $this->apiGroup->addGet    ('/{controller}/{id' . $id_regexp . '}', ['action' => 'get', 'namespace' => $this->namespace]);
        $this->apiGroup->addPut    ('/{controller}/{id' . $id_regexp . '}', ['action' => 'put', 'namespace' => $this->namespace]);
        $this->apiGroup->addPatch  ('/{controller}/{id' . $id_regexp . '}', ['action' => 'patch', 'namespace' => $this->namespace]);
        $this->apiGroup->addHead   ('/{controller}/{id' . $id_regexp . '}', ['action' => 'head', 'namespace' => $this->namespace]);
        $this->apiGroup->addDelete ('/{controller}/{id' . $id_regexp . '}', ['action' => 'delete', 'namespace' => $this->namespace]);
        $this->apiGroup->add       ('/{controller}/{id' . $id_regexp . '}/{action}', ['namespace' => $this->namespace]);

        return $this;
    }

    /**
     * @param Router $router
     * @return $this
     */
    public function mountTo(Router $router)
    {
        $router->mount($this->apiGroup);
        return $this;
    }

    /**
     * @return Group
     */
    public function getApiGroup()
    {
        return $this->apiGroup;
    }

    /**
     * @param Group $group
     * @return $this
     */
    public function setApiGroup(Group $group)
    {
        $this->apiGroup = $group;
        return $this;
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
}
