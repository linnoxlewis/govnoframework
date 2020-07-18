<?php

namespace core;

use core\base\controllers\Controller;
use Exception;

/**
 * Class for create path to controller and run it
 *
 * Class Route
 *
 * @package core
 */
class Route
{
    /**
     * default public controller
     *
     * @var string
     */
    protected $defaultController = 'SiteController';

    /**
     * default action name
     *
     * @var string
     */
    protected $defaultAction = 'index';

    /**
     * input route
     *
     * @var array
     */
    protected $route = [];

    /**
     * Run action
     *
     * @throws Exception
     */
    public function run()
    {
        $this->route = $this->getUrl();
        $controller = $this->getController();
        $action = $this->getActionName();
        if (!method_exists($controller, $action)) {
            throw new Exception('Method ' . $action . 'not found in controller', 404);
        }
        $controller->$action();
    }

    /**
     * Get controller object
     *
     * @return object
     * @throws Exception
     */
    protected function getController() : Controller
    {
        $controllerName = (!empty($this->route[1]))
            ? ucfirst($this->route[1] . "Controller")
            : $this->defaultController;
        $controllerName = 'controllers' . '\\' . $controllerName;
        if (!class_exists($controllerName)) {
            throw new Exception('Class' . $controllerName . 'not found', 404);
        }
        return new $controllerName();
    }

    /**
     * Get action name
     *
     * @return string
     */
    protected function getActionName() : string
    {
        $action = (isset($this->route[2]) && !empty($this->route[2]))
            ? $action = $this->route[2]
            : $this->defaultAction;
        return $action;
    }

    /**
     * Create url
     *
     * @return array
     */
    protected function getUrl() : array
    {
        $url = strtok($_SERVER['REQUEST_URI'],'?');
        $url = quotemeta($url);
        return explode("/",$url);
    }
}
