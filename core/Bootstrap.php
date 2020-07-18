<?php

namespace core;


use core\base\abstracts\ModelValidatorInterface;
use core\base\container\Container;
use core\base\validators\ModelValidator;
use App;

/**
 * Load application
 *
 * Class Bootstrap
 *
 * @package core
 */
class Bootstrap
{
    /**
     * @throws \Exception
     */
    public function run()
    {
        $router = new Route();
        App::$container = new Container();
        App::$config = new Config();
        App::$service = new Service(App::$container, App::$config);
        App::$container->set(ModelValidatorInterface::class, ModelValidator::class);
        $router->run();
    }
}
