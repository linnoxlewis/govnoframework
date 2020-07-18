<?php

return [
    'application' => [
        'id' => 'test',
        'name' => 'My framework',
        'description' => 'description here...'
    ],
    'services' => [
        'cache' => [
            'host' => '127.0.0.1',
            'port' => 6379
        ],
        'DB'=> [
            'host' => '127.0.0.1',
            'user'=> 'homestead',
            'password' => 'secret',
            'type' => 'mysql',
            'port' => 3306,
            'database' => 'blockchain',
            'data' => 23,
        ],
    ],
    'params' => [],
];