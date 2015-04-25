<?php

namespace PhalconRest;

use Phalcon\DI;
use Phalcon\DI\Injectable;
use Phalcon\DI\InjectionAwareInterface;
use Phalcon\DiInterface;
use Phalcon\Events\EventsAwareInterface;
use PhalconRest\Plugins\DispatcherEventsHandler;

class ServiceProvider extends Injectable implements EventsAwareInterface, InjectionAwareInterface
{

    public function __construct(DiInterface $di = null)
    {
        if (!$di) {
            $di = DI::getDefault();
        }

        $eventsManager = $di->get('eventsManager');
        $eventsManager->attach('dispatch', new DispatcherEventsHandler($di));

        $dispatcher = $di->get('dispatcher');
        $dispatcher->setEventsManager($eventsManager);


        $di->set('restView', function() use($di) {
            $view = new \PhalconRest\Mvc\RestView();
            $view->registerEngines([
                'application/json' => new \PhalconRest\Mvc\View\Engine\Json($view, $di),
                //'application/xml' =>  new \PhalconRest\Mvc\View\Engine\Xml($view, $di),
                //'text/html' =>  new \PhalconRest\Mvc\View\Engine\Php($view, $di),
            ]);

            return $view;
        }, true);

    }
}