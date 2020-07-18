<?php
use core\Bootstrap;
use core\base\controllers\ErrorController;

/**
 * Base application class
 *
 * Class Application
 */
class Application
{
    /**
     * Run method
     */
    public function run()
    {
        try {
            spl_autoload_register(['ClassLoader', 'autoload'], true, true);
            $bootstrap = new Bootstrap();
            $bootstrap->run();
        } catch (Exception $e) {
            require CORE_DIR . 'base' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'ErrorController.php';
            $errorController = new ErrorController($e->getMessage(), $e->getCode(), $e->getTraceAsString());
            $errorController->index();
            exit;
        }
    }
}
