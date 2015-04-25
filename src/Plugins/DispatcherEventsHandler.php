<?php

namespace PhalconRest\Plugins;

use Phalcon\DI;
use Phalcon\Events\Event;
use Phalcon\Exception;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;

class DispatcherEventsHandler extends Plugin
{

    protected $method_key = '_method';

    protected $format_key = '_format';


    public function __construct(DI $di)
    {
        $this->setDI($di);
    }

    public function beforeDispatchLoop(Event $event, Dispatcher $dispatcher)
    {
    }

    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $di = $this->getDI();
        $request = $di->get('request');

        if (!$dispatcher->wasForwarded()) {
            if ($request->has($this->method_key)) {
                $method = $request->get($this->method_key);
            } else {
                $method = $request->getHeader('X-HTTP-Method-Override');
            }

            if (!empty($method)) {
                $dispatcher->forward(['action' => $method]);
            }
        }


        if ($request->has($this->format_key)) {
            $mime = 'application/' . $request->get($this->format_key);
        } else {
            $parts = explode(';', $request->getHeader('Accept'));
            $mime = reset($parts);
        }

        if (empty($mime)) {
            $mime = 'application/json';
        }

        $restView = $di->get('restView');
        $restView->setFormat($mime);
    }

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
    }

    public function afterExecuteRoute(Event $event, Dispatcher $dispatcher, $exception)
    {
    }

    public function beforeNotFoundAction()
    {
    }

    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
    {
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                //$dispatcher->forward([
                //    'controller' => 'error',
                //    'action' => 'show404'
                //]);

                return false;
        }
    }

    public function afterDispatch(Event $event, Dispatcher $dispatcher)
    {
    }

    public function afterDispatchLoop(Event $event, Dispatcher $dispatcher)
    {
    }

    /**
     * @return string
     */
    public function getMethodKey()
    {
        return $this->method_key;
    }

    /**
     * @param string $method_key
     * @return $this
     */
    public function setMethodKey($method_key)
    {
        $this->method_key = $method_key;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormatKey()
    {
        return $this->format_key;
    }

    /**
     * @param string $format_key
     * @return bool
     */
    public function setFormatKey($format_key)
    {
        $this->format_key = $format_key;
        return true;
    }
}
