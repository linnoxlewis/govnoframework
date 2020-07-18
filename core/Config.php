<?php
namespace core;
require_once __DIR__ . DIRECTORY_SEPARATOR .  'base' . DIRECTORY_SEPARATOR . 'abstracts' . DIRECTORY_SEPARATOR . 'ConfigInterface.php';
use core\base\abstracts\ConfigInterface;

/**
 * Class Config
 *
 * @package core
 */
class Config implements ConfigInterface
{
    /**
     * Base config Path
     *
     * @var string
     */
    protected static $baseConfigPath = VENDOR_DIR . 'BaseConfig.php';

    /**
     * Application config path
     *
     * @var string
     */
    protected static $applicationConfigPath = CONFIG_WEB . 'web.php';

    /**
     * Get all configuration
     *
     * @return array
     *
     * @throws \Exception
     */
    public static function getConfig(): array
    {
        $baseConfig = static::getBaseConfig();
        $applicationConfig = static::getApplicationConfig();

        return array_merge_recursive($baseConfig, $applicationConfig);
    }

    /**
     * Get configuration by name
     *
     * @return array
     *
     * @throws \Exception
     */
    public static function getConfigByKey($key): array
    {
        $config = static::getConfig();

        return isset($config[$key]) ? $config[$key] : [];
    }

    /**
     * Get base configuration
     *
     * @return mixed
     * @throws \Exception
     */
    protected static function getBaseConfig()
    {
        if (!file_exists(static::$baseConfigPath)) {
            throw new \Exception('Base config file not found in ' . static::$baseConfigPath);
        }
        $config = require static::$baseConfigPath;
        if (!is_array($config) || empty($config)) {
            throw new \Exception('Invalid Base Config', 500);
        }

        return $config;
    }

    /**
     * Get application config
     *
     * @return mixed
     * @throws \Exception
     */
    protected static function getApplicationConfig()
    {
        if (!file_exists(static::$applicationConfigPath)) {
            throw new \Exception('Application config file not found in ' . static::$applicationConfigPath);
        }
        $config = require static::$applicationConfigPath;
        if (!is_array($config) || empty($config)) {
            throw new \Exception('Invalid Application Config', 500);
        }

        return $config;
    }

    /**
     * Get services config
     *
     * @return array
     * @throws \Exception
     */
    public static function getServices() : array
    {
        return static::getConfigByKey('services');
    }

    /**
     * Get service config
     *
     * @param string $serviceName service name
     *
     * @return array|null
     * @throws \Exception
     */
    public static function getService(string $serviceName)
    {
        $services = static::getServices();

        return (!empty($services) && isset($services["$serviceName"]))
            ? $services["$serviceName"]
            : null;
    }

    /**
     * Get params
     *
     * @return array
     * @throws \Exception
     */
    public static function getParams() : array
    {
        return static::getConfigByKey('params');
    }

    /**
     * Get param
     *
     * @param string $paramName param
     *
     * @return array|null
     * @throws \Exception
     */
    public static function getParam(string $paramName)
    {
        $params = static::getParams();

        return (!empty($params) && isset($services["$paramName"]))
            ? $params["$paramName"]
            : null;
    }

    /**
     * Get db params
     *
     * @return array|null
     * @throws \Exception
     */
    public static function getDbParams()
    {
        $services = static::getServices();
        return $services['DB'];
    }
}
