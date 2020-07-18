<?php

namespace core\base\abstracts;

/**
 * Class for show user data
 *
 * Class View
 *
 * @package core
 */
interface RequestInterface
{
    /**
     * Return get param
     *
     * @param string $name         param name
     * @param null   $defaultValue value if get is empty
     *
     * @return mixed|null
     */
    public function get(string $name, $defaultValue = null);

    /**
     * Return post param
     *
     * @param string $name         param name
     * @param null   $defaultValue value if post is empty
     *
     * @return mixed|null
     */
    public function post(string $name, $defaultValue = null);

    /**
     * Return all get params
     *
     * @return array
     */
    public function getAll() : array ;

    /**
     * Return all post params
     *
     * @return array
     */
    public function postAll() : array ;

    /**
     * Return all params
     *
     * @return mixed
     */
    public function all();

    /**
     * Return all headers
     *
     * @return array
     */
    public function getHeaders() : array;

    /**
     * Return header
     *
     * @param string $key header name
     *
     * @return mixed|null
     */
    public function getHeader(string $key) ;

    /**
     * Check is method is get
     *
     * @return bool
     */
    public function isGet() : bool ;

    /**
     * Check is method is post
     *
     * @return bool
     */
    public function isPost() : bool ;

    /**
     * Check is method is ajax
     *
     * @return bool
     */
    public function isAjax() : bool ;
}
