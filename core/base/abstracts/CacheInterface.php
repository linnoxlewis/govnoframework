<?php

namespace services\cache;

interface CacheInterface
{
    /**
     * Create service connection
     *
     * @param string $host host
     * @param int    $port port
     *
     * @return object
     */
    public function serviceConnect($host, $port);

    /**
     * Get value by key
     *
     * @param string $key key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Set value from Key
     *
     * @param string      $key      key
     * @param mixed       $value    value
     * @param string|null $duration duration time
     *
     * @return bool
     */
    public function set($key, $value, $duration = null);

    /**
     * Get value from Key, set if not exist
     *
     * @param string      $key      key
     * @param mixed       $value    value
     * @param string|null $duration duration time
     *
     * @return mixed
     */
    public function getOrSet($key, $value, $duration = null);

    /**
     * Increment value
     *
     * @param string $key key
     *
     * @return int
     */
    public function increment($key);

    /**
     * Decrement value
     *
     * @param string $key key
     *
     * @return int
     */
    public function decrement($key);

    /**
     * Delete all keys
     *
     * @return bool
     */
    public function delete();

    /**
     * Delete value by key
     *
     * @param string $key key
     *
     * @return bool
     */
    public function deleteByKey($key);

    /**
     * Exist key
     *
     * @param string $key key
     *
     * @return bool
     */
    public function exist($key);

    /**
     * Get Error message
     *
     * @return mixed
     */
    public function getError();
}