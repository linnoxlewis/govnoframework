<?php

namespace core\base\services;

use services\cache\CacheInterface;

class Cache
{
    /**
     * Cache service
     *
     * @var object
     */
    protected $service;

    /**
     * Cache constructor.
     *
     * @param CacheInterface $cache cache service
     * @param string $host host
     * @param int $port port
     *
     */
    public function __construct(CacheInterface $cache,string $host, int $port)
    {
       $this->service = $cache->serviceConnect($host,$port);
    }

    /**
     * Call method db
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (!method_exists($this->service, $name) && !in_array($name,get_class_methods($this->service))) {
            throw new \Exception('Method ' . $name . ' not found ');
        }
        try {
            $result = call_user_func_array([$this->service, $name], $arguments);
            if (!empty($error = $this->service->getError())){
                throw new \Exception($error,400);
            }
            return $result;
        } catch (\Throwable $e){
            throw new \Exception($e->getMessage(),400);
        }

    }
}
