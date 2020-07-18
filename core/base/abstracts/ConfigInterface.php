<?php

namespace core\base\abstracts;

/**
 * Class for show user data
 *
 * Class View
 *
 * @package core
 */
interface ConfigInterface
{
    public static function getConfig();

    public static function getConfigByKey($key);

    /**
     * Get services config
     *
     * @return array
     * @throws \Exception
     */
    public static function getServices() : array ;

    /**
     * Get service config
     *
     * @param string $serviceName service name
     *
     * @return array|null
     * @throws \Exception
     */
    public static function getService(string $serviceName);

    /**
     * Get params
     *
     * @return array
     * @throws \Exception
     */
    public static function getParams() : array ;


    /**
     * Get param
     *
     * @param string $paramName param
     *
     * @return array|null
     * @throws \Exception
     */
    public static function getParam(string $paramName);

    /**
     * Get service config
     *
     * @param string $serviceName service name
     *
     * @return array|null
     * @throws \Exception
     */
    public static function getDbParams();

}
