<?php

namespace core\base\services;

use core\base\abstracts\BaseService;
use core\base\abstracts\SessionFlashInterface;
use core\base\abstracts\SessionInterface;

/**
 * Class Session
 *
 * @package core\base\services
 */
class Session extends BaseService implements SessionInterface, SessionFlashInterface
{
    /**
     * Frozen session
     *
     * @var mixed
     */
    protected $frozenSession;

    /**
     * Check is active session
     *
     * @return bool
     */
    public function isActive()
    {
        return session_status() == PHP_SESSION_ACTIVE;
    }

    /**
     * Open session
     *
     * @return bool
     */
    public function open()
    {
        if ($this->IsActive()) {
            return true;
        }
        return session_start();
    }

    /**
     * Close session
     *
     * @return void
     */
    public function close()
    {
        if ($this->isActive()) {
            session_write_close();
        }
    }

    /**
     * Destroy session
     *
     * @return void
     */
    public function destroy()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Get session from key
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Add value in session
     *
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * Remove session|value in session
     *
     * @param null|string $key
     */
    public function remove($key = null)
    {
        if (is_null($key)) {
            session_unset();
        } else {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Check exist value in session
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Get session id
     *
     * @return string
     */
    public function getSessionId()
    {
        return session_id();
    }

    /**
     * Set session id
     *
     * @param string|integer $id
     */
    public function setSessionId($id)
    {
        session_id($id);
    }

    /**
     * Regeneration session id
     *
     * @param bool $deleteOldSession delete last seeion or not
     */
    public function regenerateSessionId($deleteOldSession = false)
    {
        if ($this->isActive()) {
            session_regenerate_id($deleteOldSession);
        }
    }

    /**
     * Isset session with id
     *
     * @return bool
     */
    public function hasSessionId()
    {
        return !empty(session_id());
    }

    /**
     * Get session name
     *
     * @return string
     */
    public function getSessionName()
    {
        return session_name();
    }

    /**
     * Set session name
     *
     * @param string $value
     */
    public function setSessionName($value)
    {
        $this->freezeSession();
        session_name($value);
        $this->unfreezeSession();
    }

    /**
     * Freeze this session
     *
     * @return void
     */
    protected function freezeSession()
    {
        if ($this->isActive()) {
            if (isset($_SESSION)) {
                $this->frozenSession = $_SESSION;
            }
            $this->close();
        }
    }

    /**
     * Unfreeze session
     *
     * @return void
     */
    protected function unfreezeSession()
    {
        if (null !== $this->frozenSession) {
            session_start();
            $_SESSION = $this->frozenSession;
            $this->frozenSession = null;
        }
    }

    /**
     * Set flash message
     *
     * @param string $key message key
     * @param string $value message value
     *
     * @return mixed
     */
    public function setFlashMessage(string $key, string $value)
    {
        return $this->set($key, $value);

    }

    /**
     * Get flash message
     *
     * @param string $key message key
     * @param string $defaultValue default message value
     *
     * @return mixed|null
     */
    public function getFlashMessage(string $key, string $defaultValue = null)
    {
        $value = $this->get($key);
        return (!empty($value)) ? $value : $defaultValue;
    }

    /**
     * Isset flash message
     *
     * @param string $key key message
     *
     * @return bool
     */
    public function hasFlashMessage(string $key)
    {
        return $this->has($key);
    }

    /**
     * Add flash message
     *
     * @param string $key message key
     * @param string $value message value
     *
     * @return void
     */
    public function addFlashMessage(string $key, string $value)
    {
        if (empty($_SESSION[$key])) {
            $_SESSION[$key] = [$value];
        } elseif (is_array($_SESSION[$key])) {
            $_SESSION[$key][] = $value;
        } else {
            $_SESSION[$key] = [$_SESSION[$key], $value];
        }
    }

    /**
     * Remove flash message
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function removeFlashMessage(string $key)
    {
        $value = isset($_SESSION[$key], $counters[$key]) ? $_SESSION[$key] : null;
        unset($_SESSION[$key]);
        return $value;
    }
}
