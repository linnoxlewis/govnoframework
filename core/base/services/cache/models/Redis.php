<?php

namespace core\base\services\cache\models;

use services\cache\CacheInterface;

/**
 * Class Redis
 *
 * @package services\cache\models
 */
class Redis implements CacheInterface
{
    /**
     * Redis cache
     *
     * @var \Redis
     */
    protected $redis;

    /**
     * Create service connection
     *
     * @param string $host host
     * @param int $port port
     *
     * @return object
     */
    public function serviceConnect($host, $port)
    {
        $this->redis = new \Redis();
        $this->redis->connect($host, $port);
        return clone $this;
    }

    /**
     * Get value by key
     *
     * @param string $key key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }

    /**
     * Set value from Key
     *
     * @param string $key key
     * @param mixed $value value
     * @param string|null $duration duration time
     *
     * @return bool
     */
    public function set($key, $value, $duration = null)
    {
        return (empty($duration))
            ? $this->redis->set($key, $value)
            : $this->redis->set($key, $value, $duration);
    }

    /**
     * Get value from Key, set if not exist
     *
     * @param string $key key
     * @param mixed $value value
     * @param string|null $duration duration time
     *
     * @return mixed
     */
    public function getOrSet($key, $value, $duration = null)
    {
        $result = $this->redis->get($key);
        if (empty($result) && $this->redis->set($key, $value, $duration)) {
            $result = $this->redis->get($key);
        }
        return $result;
    }

    /**
     * Increment value
     *
     * @param string $key key
     *
     * @return int
     */
    public function increment($key)
    {
        return $this->redis->incr($key);
    }

    /**
     * Decrement value
     *
     * @param string $key key
     *
     * @return int
     */
    public function decrement($key)
    {
        return $this->redis->decr($key);
    }

    /**
     * Delete all keys
     *
     * @return bool
     */
    public function delete()
    {
        return $this->redis->flushAll();
    }

    /**
     * Delete value by key
     *
     * @param string $key key
     *
     * @return bool
     */
    public function deleteByKey($key)
    {
        return $this->redis->del($key);
    }

    /**
     * Exist key
     *
     * @param string $key key
     *
     * @return bool
     */
    public function exist($key)
    {
        return $this->redis->exists($key);
    }

    /**
     * Get Error message
     *
     * @return mixed
     */
    public function getError()
    {
        return $this->redis->getLastError();
    }
}
