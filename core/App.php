<?php

use core\base\abstracts\ConfigInterface;
use core\Service;

/**
 * Base App class
 *
 * Class App
 */
class App
{
    /**
     * Service class
     *
     * @var Service
     */
    public static $service;

    /**
     * DI container
     *
     */
    public static $container;

    /**
     * Config class
     *
     * @var ConfigInterface
     */
    public static $config;
}


