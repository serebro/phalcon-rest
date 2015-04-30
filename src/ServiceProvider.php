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


        $di->set('rest', function() use($di) {
            $rest = new \PhalconRest\Mvc\RestView();
            $rest->setBasePath('../app/rest/');
            $rest->registerEngines([
                'application/json' => new \PhalconRest\Mvc\Rest\Engine\Json($rest, $di),
                //'application/xml' =>  new \PhalconRest\Mvc\Rest\Engine\Xml($rest, $di),
                //'text/html' =>  new \PhalconRest\Mvc\View\Engine\Php($rest, $di),
            ]);

            return $rest;
        }, true);

    }
}