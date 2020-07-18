<?php

namespace core\base\abstracts;

/**
 * Cookie interface
 *
 * Interface CookieInterface
 *
 * @package core\base\abstracts
 */
interface CookieInterface
{
    /**
     * Get cookie
     *
     * @param string $key key cookie
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Set cookie
     *
     * @param string $key key cookie
     * @param mixed $value cookie value
     * @param int $expires time cookie
     *
     * @return bool
     */
    public function set(string $key, $value, int $expires = 0);

    /**
     * Validate exist cookie
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key);
}
