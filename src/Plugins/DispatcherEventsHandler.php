<?php

namespace PhalconRest\Plugins;

use Phalcon\DI;
use Phalcon\Events\Event;
use Exception;
use Phalcon\Events\Manager;
use Phalcon\Events\ManagerInterface;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;
use PhalconRest\Exception\AbstractResponse;
use PhalconRest\Mvc\RestControllerInterface;

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

        if (empty($mime) || $mime == '*/*') {
            $mime = 'application/json';
        }

        $rest = $di->get('rest');
        $rest->setFormat($mime);
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
        $di = $this->getDI();
        $response = $di->get('response');

        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->forward([
                    'controller' => 'error',
                    'action' => 'show404'
                ]);

                return false;
        }

        if ($exception instanceof AbstractResponse) {
            $response
                ->setContent($exception->getMessage())
                ->setStatusCode($exception->getStatusCode(), $exception->getStatusMessage());

            $dispatcher->setReturnedValue($response);

            return false;
        }

        //return $response->setContent($exception->getMessage() . ', ' . $exception->getFile() . ':' . $exception->getLine());
    }

    public function afterDispatch(Event $event, Dispatcher $dispatcher)
    {
    }

    public function afterDispatchLoop(Event $event, Dispatcher $dispatcher)
    {
        $di = $this->getDI();
        $response = $di->get('response');
        $content = $response->getContent();

        if ($content === '' && $dispatcher->getActiveController() instanceof RestControllerInterface) {
            $returnedResponse = $dispatcher->getReturnedValue() instanceof ResponseInterface;
            if ($returnedResponse === false) {
                /** @var \PhalconRest\Mvc\RestView $rest */
                $rest = $di->get('rest');

                /** @var Manager $eventsManager */
                $eventsManager = $this->_eventsManager; //$eventsManager = $dispatcher->getDI()->get('eventsManager');

                $renderStatus = true;
                if ($eventsManager instanceof ManagerInterface) {
                    $renderStatus = $eventsManager->fire('application:viewRender', $this, $rest);
                }

                if ($renderStatus) {
                    $rest->render($dispatcher->getControllerName(), $dispatcher->getActionName());
                    $content = $rest->getContent();
                }

                /** @var \Phalcon\Http\Response $response */
                $response = $di->get('response');
                $response->setContent($content)->send();
            }
        }
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
