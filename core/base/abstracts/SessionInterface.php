<?php

namespace core\base\abstracts;

/**
 * Session interface
 *
 * Interface SessionInterface
 *
 * @package core\base\abstracts
 */
interface SessionInterface
{
    /**
     * Check is active session
     *
     * @return bool
     */
    public function isActive();

    /**
     * Open session
     *
     * @return bool
     */
    public function open();

    /**
     * Close session
     *
     * @return void
     */
    public function close();

    /**
     * Destroy session
     *
     * @return bool
     */
    public function destroy();

    /**
     * Get session from key
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function get($key);

    /**
     * Add value in session
     *
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function set($key, $value);

    /**
     * Remove session|value in session
     *
     * @param null|string $key
     */
    public function remove($key = null);

    /**
     * Check exist value in session
     *
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * Get session id
     *
     * @return string
     */
    public function getSessionId();

    /**
     * Set session id
     *
     * @param string|integer $id
     */
    public function setSessionId($id);

    /**
     * Regeneration session id
     *
     * @param bool $deleteOldSession delete last seeion or not
     */
    public function regenerateSessionId($deleteOldSession = false);

    /**
     * Isset session with id
     *
     * @return bool
     */
    public function hasSessionId();

    /**
     * Get session name
     *
     * @return string
     */
    public function getSessionName();

    /**
     * Set session name
     *
     * @param string $value
     */
    public function setSessionName($value);
}
