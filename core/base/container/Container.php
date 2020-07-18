<?php

namespace core\base\container;

use core\base\abstracts\ContainerInterface;
use ReflectionClass;
use Exception;

/**
 * Class Container
 */
class Container implements ContainerInterface
{
    /**
     * Class instanses
     *
     * @var array
     */
    protected $instances = [];

    /**
     * Set di
     *
     * @param      $abstract
     * @param null $concrete
     */
    public function set($abstract, $concrete = NULL)
    {
        if ($concrete === NULL) {
            $concrete = $abstract;
        }
        $this->instances[$abstract] = $concrete;
    }

    /**
     * Get class form abstract
     *
     * @param       $abstract
     * @param array $parameters
     *
     * @return mixed|null|object
     * @throws Exception
     */
    public function get($abstract, $parameters = [])
    {
        if (!isset($this->instances[$abstract])) {
            $this->set($abstract);
        }
        return $this->resolve($this->instances[$abstract], $parameters);
    }

    /**
     * resolve single
     *
     * @param $concrete
     * @param $parameters
     *
     * @return mixed|object
     * @throws Exception
     */
    public function resolve($concrete, $params)
    {
        if ($concrete instanceof \Closure) {
            return $concrete($this, $params);
        }
        $reflector = new ReflectionClass($concrete);
        if (!$reflector->isInstantiable()) {
            throw new Exception("Class {$concrete} is not instantiable");
        }
        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return $reflector->newInstance();
        }
        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters, $params );
        return $reflector->newInstanceArgs($dependencies);

    }

    /**
     * get all dependencies resolved
     *
     * @param $parameters
     *
     * @return array
     * @throws Exception
     */
    public function getDependencies($parameters, $params = [])
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            if ($dependency === NULL) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } elseif (isset($params[$parameter->name])) {
                    $dependencies[] = $params[$parameter->name];
                } else {
                    throw new Exception("Can not resolve class dependency {$parameter->name}. Property {$parameter->name} isset? " );
                }
            } else {
                $dependencies[] = $this->get($dependency->name);
            }
        }
        return $dependencies;
    }
}
