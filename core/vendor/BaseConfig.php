<?php

use core\base\services\Cache;
use core\base\services\db\DB;
use core\base\services\db\models\PdoDB;
use core\base\services\cache\models\Memcache;
use core\base\services\cache\models\Redis;
use core\base\services\Request;
use core\base\services\Session;

return [
    'services' => [
        'cache' => [
            'class' => Cache::class,
            'model' => Redis::class,
        ],
        'DB' => [
            'model' => PdoDB::class,
            'class' => DB::class
        ],
        'request' => [
            'class' => Request::class
        ],
        'session' => [
            'class' => Session::class
        ]
    ],
    'params' => [],
];
