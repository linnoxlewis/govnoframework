<?php

namespace core\base\services\cache\models;

use services\cache\CacheInterface;

/**
 * Class Memcached
 *
 * @package services\cache\models
 */
class Memcache implements CacheInterface
{
    /**
     * Memcached service
     *
     * @var \Memcached
     */
    protected $memcached;

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
        $this->memcached = new \Memcached();
        $this->memcached->addServer($host, $port);
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
        return $this->memcached->get($key);
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
        $this->memcached->set($key, $value);
        return (empty($duration))
            ? $this->memcached->set($key, $value)
            : $this->memcached->set($key, $value, $duration);
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
        $result = $this->memcached->get($key);
        if (empty($result) && $this->memcached->set($key, $value, $duration)) {
            $result = $this->memcached->get($key);
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
        return $this->memcached->increment($key);
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
        return $this->memcached->decrement($key);
    }

    /**
     * Delete all keys
     *
     * @return bool
     */
    public function delete()
    {
        return $this->memcached->flush();
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
        return $this->memcached->delete($key);
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
        $value = $this->memcached->get($key);
        return (!empty($value));
    }

    /**
     * Get last Error
     *
     * @return mixed|void|null
     */
    public function getError()
    {
        $error = $this->memcached->getLastErrorMessage();
        return (!empty($error) && strtoupper($error) !== 'SUCCESS')
            ? $error
            : null;
    }
}
