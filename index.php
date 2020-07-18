<?php

use core\App;

include 'core' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'Globals.php';
require_once VENDOR_DIR  . 'Autoload.php';
require_once VENDOR_DIR  . 'Application.php';
require CORE_DIR . 'App.php';

$application = new Application();
$application->run();