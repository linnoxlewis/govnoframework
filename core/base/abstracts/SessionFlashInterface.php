<?php

namespace core\base\abstracts;

/**
 * Flash message interface
 *
 * Interface SessionFlashInterface
 *
 * @package core\base\abstracts
 */
interface SessionFlashInterface
{
    /**
     * Set flash message
     *
     * @param string $key   message key
     * @param string $value message value
     *
     * @return mixed
     */
    public function setFlashMessage(string $key, string $value);

    /**
     * Get flash message
     *
     * @param string $key   message key
     * @param string $defaultValue default message value
     *
     * @return mixed|null
     */
    public function getFlashMessage(string $key, string $defaultValue = null);

    /**
     * Isset flash message
     *
     * @param string $key key message
     *
     * @return bool
     */
    public function hasFlashMessage(string $key);

    /**
     * Add flash message
     *
     * @param string $key   message key
     * @param string $value message value
     *
     * @return void
     */
    public function addFlashMessage(string $key, string $value);

    /**
     * Remove flash message
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function removeFlashMessage(string $key);
}
