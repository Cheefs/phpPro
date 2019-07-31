<?php
return [
    'root' => $_SERVER['DOCUMENT_ROOT'].'/../',
    'name' => 'Brand',
    'defaultController' => 'default',
    'defaultAction' => 'index',

    'components' => [
        'db' => [
            'class' => \app\services\DB::class,
            'config' => [
                'userName' => 'root',
                'password' => '',
                'dbName' => 'shop',
                'dbHost' => 'localhost',
                'driver' => 'mysql',
                'charset' => 'utf8'
            ]
        ]
    ]
];