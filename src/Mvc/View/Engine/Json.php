<?php

namespace Phalcon\Mvc\View\Engine;

class Json extends \Phalcon\Mvc\View\Engine\Php
{

	protected $json_encode_options;


	public function render($path, $params, $mustClean = null)
	{
		if (is_array($params)) {
			extract($params);
		}

		$content = require $path;
		if ($mustClean === true) {
			$content = json_encode($content, $this->json_encode_options);
			$this->_view->setContent($content);
		} else {
			$this->_view->setData($content);
		}
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
}
