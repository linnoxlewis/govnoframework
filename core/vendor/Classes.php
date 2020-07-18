<?php

$abstractsClasses = [
    'ViewInterface' => 'base/abstracts/ViewInterface.php',
    'ConfigInterface' => 'base/abstracts/ConfigInterface.php',
    'RequestInterface' => 'base/abstracts/RequestInterface.php',
    'BaseService' => 'base/abstracts/BaseService.php',
    'DbInterface' => 'base/abstracts/DbInterface.php',
    'ContainerInterface' => 'base/abstracts/ContainerInterface.php',
    'CacheInterface' => 'base/abstracts/CacheInterface.php',
    'ModelValidatorInterface' => 'base/abstracts/ModelValidatorInterface.php',
    'ModelErrorsInterface' => 'base/abstracts/ModelErrorsInterface.php',
    'ModelAttributesInterface' => 'base/abstracts/ModelAttributesInterface.php',
    'ModelValidateInterface' => 'base/abstracts/ModelValidateInterface.php',
    'SessionInterface' => 'base/abstracts/SessionInterface.php',
    'SessionFlashInterface' => 'base/abstracts/SessionFlashInterface.php',
    'CookieInterface' => 'base/abstracts/CookieInterface.php'
];

$baseClasses = [
    'Container' =>'base/container/Container.php',
    'ErrorController' => 'base/controllers/ErrorController.php',
    'Controller' =>  'base/controllers/Controller.php',
    'Route' => 'Route.php',
    'Page' => 'Page.php',
    'View' => 'View.php',
    'Config' => 'Config.php',
    'Service' => 'Service.php',
    'Model' => 'base/models/Model.php',
    'Bootstrap' => 'Bootstrap.php'
];

$baseServices = [
    'Cache' =>'base/services/cache/Cache.php',
    'Request' => 'base/services/Request.php',
    'Session' => 'base/services/Session.php'
];

$configFiles = [];

return array_merge($abstractsClasses,$baseClasses,$configFiles,$baseServices);
