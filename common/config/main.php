<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    'components' => [
        'db' => [
            'class' => 'common\components\db\Connection',
            'schemaMap' => [
                'mysql' => 'common\components\db\mysql\Schema',
            ],
            'tableMap' => [
                '%migration' => '%__db__migration',
                '%session' => '%__web__session',

                '%auth_assignment' => '%__rbac__auth_assignment',
                '%auth_item' => '%__rbac__auth_item',
                '%auth_item_child' => '%__rbac__auth_item_child',
                '%auth_rule' => '%__rbac__auth_rule',

                '%user' => '%__user__user',
                '%profile' => '%__user__profile',
                '%token' => '%__user__token',
                '%social_account' => '%__user__social_account',
            ],
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'php:m-d-Y',
            'datetimeFormat' => 'php:m-d-Y H:i',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['user'],
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
