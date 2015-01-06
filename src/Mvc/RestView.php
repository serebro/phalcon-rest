<?php

namespace PhalconRest\Mvc;

use Exception;
use Phalcon\Events\ManagerInterface;
use Phalcon\Mvc\View;
use PhalconRest\Mvc\View\Engine\Json as JsonEngine;

class RestView extends View
{

    /** @var  \PhalconRest\Http\Envelope */
    public $envelope;

    protected $data;


    public function partial($partialPath, array $params = null)
    {
        if (is_array($params)) {
            $viewParams = $this->_viewParams;
            if (is_array($viewParams)) {
                $this->_viewParams = array_merge($viewParams, $params);
            } else {
                $this->_viewParams = $params;
            }
        }

        $this->_engineRender($this->_loadTemplateEngines(), $this->_partialsDir . $partialPath, false, false);

        if (is_array($params)) {
            $this->_viewParams = $viewParams;
        }

        return $this->getData();
    }

    /**
     * Executes render process from dispatching data
     * @param string $controllerName
     * @param string $actionName
     * @param array  $params
     * @return $this|bool
     */
    public function render($controllerName, $actionName, $params = null)
    {
        $engines = $this->_loadTemplateEngines();
        $pickView = $this->_pickView;
        if ($pickView === null) {
            $renderView = $controllerName . '/' . $actionName;
        } else {
            $renderView = $pickView[0];
            if (isset($pickView[1])) {
                $pickViewAction = $pickView[1];
                $layoutName = $pickViewAction;
            }
        }

        if ($this->_cacheLevel) {
            $cache = $this->getCache();
        } else {
            $cache = null;
        }

        /** @var ManagerInterface $eventsManager */
        $eventsManager = $this->_eventsManager;
        if ($eventsManager) {
            if ($eventsManager->fire('view:beforeRender', $this) === false) {
                return false;
            }
        }

        $this->_content = ob_get_contents();

        $mustClean = true;
        $silence = true;

        $this->_engineRender($engines, $renderView, $silence, $mustClean, $cache);

        if ($eventsManager instanceof ManagerInterface) {
            $eventsManager->fire('view:afterRender', $this);
        }

        return $this;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function _loadTemplateEngines()
    {
        $engines = $this->_engines;
        if ($engines === false) {
            /** @var \Phalcon\DiInterface $dependencyInjector */
            $dependencyInjector = $this->_dependencyInjector;
            $engines = [];
            $registeredEngines = $this->_registeredEngines;
            if (!is_array($registeredEngines)) {
                $engines['.php'] = new JsonEngine($this, $dependencyInjector);
            } else {
                if (!is_object($dependencyInjector)) {
                    throw new Exception("A dependency injector container is required to obtain the application services");
                }

                $arguments = [$this, $dependencyInjector];
                foreach ($registeredEngines as $extension => $engineService) {
                    if (is_object($engineService)) {
                        if ($engineService instanceof \Closure) {
                            $engines[$extension] = call_user_func_array($engineService, $arguments);
                        } else {
                            $engines[$extension] = $engineService;
                        }
                    } else {
                        if (!is_string($engineService)) {
                            throw new Exception("Invalid template engine registration for extension: " . $extension);
                        }
                        $engines[$extension] = $dependencyInjector->getShared($engineService, $arguments);
                    }
                }
            }

            $this->_engines = $engines;
        }

        return $engines;
    }

    protected function _engineRender($engines, $viewPath, $silence, $mustClean, $cache = null)
    {
        $notExists = true;
        $viewsDir = $this->_viewsDir;
        $basePath = $this->_basePath;
        $viewsDirPath = $basePath . $viewsDir . $viewPath;

        if (is_object($cache)) {
            if ($cache->isStarted() == false) {
                $key = null;
                $lifetime = null;

                $viewOptions = $this->_options;

                if (is_array($viewOptions)) {
                    if (isset($viewOptions['cache'])) {
                        $cacheOptions = $viewOptions['cache'];
                        if (is_array($cacheOptions)) {
                            if (isset($cacheOptions['key'])) {
                                $key = $cacheOptions['key'];
                            }
                            if (isset($cacheOptions['lifetime'])) {
                                $lifetime = $cacheOptions['lifetime'];
                            }
                        }
                    }
                }

                if ($key === null) {
                    $key = md5($viewPath);
                }

                $cachedView = $cache->start($key, $lifetime);
                if ($cachedView !== null) {
                    $this->data = $cachedView;

                    return null;
                }
            }

            if (!$cache->isFresh()) {
                return null;
            }
        }

        $viewParams = $this->_viewParams;
        $eventsManager = $this->_eventsManager;

        foreach ($engines as $extension => $engine) {
            $viewEnginePath = $viewsDirPath . $extension;
            if (file_exists($viewEnginePath)) {
                if (is_object($eventsManager)) {
                    $this->_activeRenderPath = $viewEnginePath;
                    if ($eventsManager->fire('view:beforeRenderView', $this, $viewEnginePath) === false) {
                        continue;
                    }
                }

                $engine->render($viewEnginePath, $viewParams, $mustClean);

                $notExists = false;
                if (is_object($eventsManager)) {
                    $eventsManager->fire('view:afterRenderView', $this);
                }
                break;
            }
        }

        if ($notExists === true) {
            if (is_object($eventsManager)) {
                $this->_activeRenderPath = $viewEnginePath;
                $eventsManager->fire('view:notFoundView', $this, $viewEnginePath);
            }
            if (!$silence) {
                throw new Exception("View '" . $viewsDirPath . "' was not found in the views directory");
            }
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

}
