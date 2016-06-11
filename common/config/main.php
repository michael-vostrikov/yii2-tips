<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'php:m-d-Y',
            'datetimeFormat' => 'php:m-d-Y H:i',
        ],
    ],
];
