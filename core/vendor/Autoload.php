<?php

class ClassLoader {

    public static $classMap;

    public static $addMap = [
        'Route',
        'Router',
    ];

    public static $baseDirectories = [
        'controllers',
        'models',
        'views'
    ];

    public static function addClassMap( array $class =[])
    {
        static::$addMap = array_merge(static::$addMap, $class);
    }

    public static function autoload(string $class)
    {
        $classes = require(__DIR__ . '/Classes.php');
        $className = static::getClassName($class);
        static::$classMap = array_merge($classes, static::$addMap);
        (isset(static::$classMap[$className]))
             ? static::includeFile(static::$classMap[$className])
             : static::includeFileInDirectory($className);
        static::includeCustomFile($class);
        if (!static::checkClassExist($class)) {
           throw new Exception('Class not found: '.$className);
        }
    }

    protected static function includeCustomFile($class)
    {
        $directories = explode("\\",$class);
        $file = end($directories);
        $fileKey = array_search($file,$directories);
        unset($directories[$fileKey]);
        $path = ROOT_DIR;
        foreach ($directories as $directory) {
            $path = $path . $directory . DIRECTORY_SEPARATOR ;
            if(!is_dir($path)) {
                throw new Exception('Directory not found: '. $path);
            }
        }
        $filename = $path . $file . ".php";
        if (is_readable($filename)) {
          require_once $filename;
        }
    }

    protected static function includeFileInDirectory($className)
    {
        foreach (static::$baseDirectories as $directory) {
            $filename = ROOT_DIR . $directory . '/'. $className . ".php";
            if (is_readable($filename)) {
                require_once $filename;
            }
        }
    }

    protected static function includeFile($class)
    {
        return include_once CORE_DIR . $class;
    }

    protected static function checkClassExist($className)
    {
        return class_exists($className, false)
            || interface_exists($className, false)
            || trait_exists($className, false);
    }

    private static function getClassName($className)
    {
        $className = explode('\\', $className);
        return end($className);
    }
}
