<?php

namespace core;

use core\base\abstracts\ConfigInterface;
use core\base\abstracts\ContainerInterface;

/**
 * Service base class
 *
 * Class Service
 *
 * @package core
 */
class Service
{
    /**
     * Service list
     *
     * @var array
     */
    protected static $serviceList;

    /**
     * Container class
     *
     * @var ContainerInterface
     */
    public $container;

    /**
     * Config class
     *
     * @var ConfigInterface
     */
    public $config;

    /**
     * Service constructor
     *
     * @param ContainerInterface $container
     * @param ConfigInterface $config
     *
     * @throws \Exception
     */
    public function __construct(ContainerInterface $container, ConfigInterface $config)
    {
        $this->container = $container;
        $this->config = $config;
        static::$serviceList = $this->config::getServices();
        foreach (static::$serviceList as $value) {
            if (!array_key_exists('class', $value) || empty($value['class'])) {
                throw new \Exception('Undefined class in component', 400);
            }
            if (!array_key_exists('model', $value) || empty($value['model'])) {
                $this->container->set($value['class']);
            } else {
                $interface = class_implements($value['model']);
                $this->container->set(key($interface), $value['model']);
            }
        }
    }

    /**
     * Return service object
     *
     * @param string $name service name
     *
     * @return object
     * @throws \Exception
     */
    public function __get($name)
    {
        if (array_key_exists(strtoupper($name), static::$serviceList)) {
            $serviceConfig = static::$serviceList[strtoupper($name)];
        } elseif (array_key_exists(strtolower($name), static::$serviceList)) {
            $serviceConfig = static::$serviceList[strtolower($name)];
        } else {
            throw new  \Exception('test');
        }
        if (!is_array($serviceConfig) || !isset($serviceConfig['class'])) {
            throw new  \Exception('field class not found in config class');
        }
        $class = $serviceConfig['class'];
        unset($serviceConfig['class']);
        if (isset($serviceConfig['model'])) {
            unset($serviceConfig['model']);
        }
        $service = $this->container->get($class, $serviceConfig);
        foreach ($serviceConfig as $key => $value) {
            if (property_exists($service, $key)) {
                $service->$key = $value;
            }
        }

        return $service;
    }
}
