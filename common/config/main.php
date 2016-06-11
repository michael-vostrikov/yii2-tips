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

    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => false,
            'enableRegistration' => false,
            'enableConfirmation' => false,
            'enablePasswordRecovery' => false,
            'enableGeneratingPassword' => false,
            'enableFlashMessages' => false,
            'admins' => ['admin'],
        ],
    ],
];
