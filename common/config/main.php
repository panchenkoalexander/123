<?php
require_once 'constants.php';

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'container' => [
            'class' => 'core\Common\Container\Container'
        ],
//        'view' => [
//            'class' => 'common\components\View'
//        ],
        'website' => [
            'class' => 'common\components\Website'
        ],
        'catalogue' => [
            'class' => 'common\components\Catalogue'
        ],
        'tecdoc' => [
            'class' => 'common\components\Tecdoc'
        ],
        'dataImporter' => [
            'class' => 'common\components\DataImporter'
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=' . Constants::SYSTEM_DBNAME,
            'username' => Constants::SYSTEM_USER,
            'password' => Constants::SYSTEM_PASSWORD,
            'charset' => 'utf8',
        ],
        'tecdocDb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=' . Constants::TECDOC_DBNAME,
            'username' => Constants::TECDOC_USER,
            'password' => Constants::TECDOC_PASSWORD,
            'charset' => 'utf8',
        ],
        'catalogueDb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname' . Constants::CATALOGUE_DBNAME,
            'username' => Constants::CATALOGUE_USER,
            'password' => Constants::CATALOGUE_PASSWORD,
            'charset' => 'utf8',
        ],
        'grabberDb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=' . Constants::GRABBER_DBNAME,
            'username' => Constants::GRABBER_USER,
            'password' => Constants::GRABBER_PASSWORD,
            'charset' => 'utf8'
        ],
//        'connectionManager' => [],
    ],
    'modules' => [
//        'forum' => [
////            'class' => 'app\modules\forum\Module',
//            // ... other configurations for the module ...
//        ],
    ],
];
