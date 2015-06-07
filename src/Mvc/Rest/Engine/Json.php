<?php

namespace PhalconRest\Mvc\Rest\Engine;

use Exception;
use Phalcon\DiInterface;
use Phalcon\Mvc\View\Engine\Php;
use Phalcon\Mvc\ViewInterface;

class Json extends Php
{

    /** @var int Default: JSON_UNESCAPED_UNICODE | JSON_BIGINT_AS_STRING */
    protected $json_encode_options;

    /** @var string */
    protected $callback_param_name = 'callback';

    /** @var string */
    protected $json_content_type = 'application/json';

    /** @var string */
    protected $jsonp_content_type = 'application/javascript';


    public function __construct(\Phalcon\Mvc\ViewBaseInterface $view, DiInterface $dependencyInjector = null)
    {
        $this->_view = $view;
        $this->setDI($dependencyInjector);
        $this->_view->envelope = new \PhalconRest\Http\Envelope\Json();
        $this->json_encode_options = JSON_UNESCAPED_UNICODE | JSON_BIGINT_AS_STRING;
    }

    /**
     * @param string $path
     * @param array  $params
     * @param bool   $mustClean
     * @throws Exception
     */
    public function render($path, $params, $mustClean = null)
    {
        $responser = require $path;
        if (!is_callable($responser, true)) {
            throw new Exception("Responser in '$path' is not callable");
        }

        $data = $responser($params);

        if ($mustClean === false) {
            $this->_view->setData($data);

            return;
        }

        if (!$this->_view->envelope->isDisabled()) {
            $data = $this->_view->envelope->setData($data)->make();
        }

        $content = json_encode($data, $this->json_encode_options);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception(json_last_error_msg());
        }

        /** @var \Phalcon\Http\RequestInterface $request */
        $request = $this->getDI()->get('request');

        /** @var \Phalcon\Http\ResponseInterface $response */
        $response = $this->getDI()->get('response');

        if ($request->has($this->callback_param_name)) {
            $callback = $request->get($this->callback_param_name);
            $content = "$callback($content);";
			$content_type = $this->jsonp_content_type;
        } else {
			$content_type = $this->json_content_type;
        }

        $response->setHeader('Content-Type', $content_type);
        $this->_view->setContent($content);
    }

    /**
     * @return mixed
     */
    public function getJsonEncodeOptions()
    {
        return $this->json_encode_options;
    }

    /**
     * @param mixed $json_encode_options
     * @return $this
     */
    public function setJsonEncodeOptions($json_encode_options)
    {
        $this->json_encode_options = $json_encode_options;

        return $this;
    }

    /**
     * @return string
     */
    public function getJsonContentType()
    {
        return $this->json_content_type;
    }

    /**
     * @param string $json_content_type
     * @return $this
     */
    public function setJsonContentType($json_content_type)
    {
        $this->json_content_type = $json_content_type;

        return $this;
    }

    /**
     * @return string
     */
    public function getJsonpContentType()
    {
        return $this->jsonp_content_type;
    }

    /**
     * @param string $jsonp_content_type
     * @return $this
     */
    public function setJsonpContentType($jsonp_content_type)
    {
        $this->jsonp_content_type = $jsonp_content_type;

        return $this;
    }

    /**
     * @return string
     */
    public function getCallbackParamName()
    {
        return $this->callback_param_name;
    }

    /**
     * @param string $callback_param_name
     * @return $this
     */
    public function setCallbackParamName($callback_param_name)
    {
        $this->callback_param_name = $callback_param_name;

        return $this;
    }
}
