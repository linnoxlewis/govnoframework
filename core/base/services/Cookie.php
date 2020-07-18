<?php

namespace core\base\services;

use core\base\abstracts\BaseService;
use core\base\abstracts\CookieInterface;

/**
 * Class Cookie
 *
 * @package core\base\services
 */
class Cookie extends BaseService implements CookieInterface
{
    /**
     * Get cookie
     *
     * @param string $key key cookie
     *
     * @return mixed
     */
    public function get($key)
    {
        return $_COOKIE[$key];
    }

    /**
     * Set cookie
     *
     * @param string $key key cookie
     * @param mixed $value cookie value
     * @param int $expires time cookie
     *
     * @return bool
     */
    public function set(string $key, $value, int $expires = 0)
    {
        return setcookie($key, $value, $expires);
    }

    /**
     * Validate exist cookie
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key)
    {
        return isset($_COOKIE[$key]);
    }
}
