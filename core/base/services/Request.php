<?php

namespace core\base\services;

use core\base\abstracts\BaseService;
use core\base\abstracts\RequestInterface;

/**
 * Class Request
 *
 * @package core
 */
class Request extends BaseService implements RequestInterface
{
    /**
     * Return get param
     *
     * @param string $name param name
     * @param null $defaultValue value if get is empty
     *
     * @return mixed|null
     */
    public function get(string $name, $defaultValue = null)
    {
        return isset($_GET[$name]) ? $_GET[$name] : $defaultValue;
    }

    /**
     * Return post param
     *
     * @param string $name param name
     * @param null $defaultValue value if post is empty
     *
     * @return mixed|null
     */
    public function post(string $name, $defaultValue = null)
    {
        return isset($_GET[$name]) ? $_GET[$name] : $defaultValue;
    }

    /**
     * Return all get params
     *
     * @return array
     */
    public function getAll(): array
    {
        return (!empty($_GET)) ? $_GET : [];
    }

    /**
     * Return all post params
     *
     * @return array
     */
    public function postAll(): array
    {
        return (!empty($_POST)) ? $_POST : [];
    }

    /**
     * Return all params
     *
     * @return mixed
     */
    public function all()
    {
        return $_REQUEST;
    }

    /**
     * Return all headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }

    /**
     * Return header
     *
     * @param string $key header name
     *
     * @return mixed|null
     */
    public function getHeader(string $key)
    {
        $headers = $this->getHeaders();
        return isset($headers["$key"]) ? $headers["$key"] : null;
    }

    /**
     * Check is method is get
     *
     * @return bool
     */
    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    /**
     * Check is method is post
     *
     * @return bool
     */
    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * Check is method is ajax
     *
     * @return bool
     */
    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}
