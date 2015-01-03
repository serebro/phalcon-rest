<?php

namespace PhalconRest\Mvc\View\Engine;

use Exception;

class Json extends \Phalcon\Mvc\View\Engine\Php
{

    /** @var int */
	protected $json_encode_options;

    protected $callback_param_name = 'callback';

    protected $json_content_type = 'application/json';

    protected $jsonp_content_type = 'application/javascript';


    /**
     * @param string $path
     * @param array  $params
     * @param bool   $mustClean
     * @throws Exception
     */
	public function render($path, $params, $mustClean = null)
	{
		if (is_array($params)) {
			extract($params);
		}

		$data = require $path;
		if ($mustClean === false) {
            $this->_view->setData($data);
            return;
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
            $response->setHeader('Content-Type', $this->jsonp_header);
        } else {
            $response->setHeader('Content-Type', $this->json_header);
        }
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
