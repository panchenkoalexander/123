<?php
/**
 * Config file for connection managers
 */
require_once(__DIR__ . '/../constants.php');

use core\Common\ConnectionManager\Manager\DbConnectionManager;
use core\Common\Container\Container;

/**
 * @var Container $container
 */
$container = \Yii::$app->container;
$dbConnectionManager = new DbConnectionManager();

$dbConnectionManager
    ->register('catalogue',
        [
            'dbname' => Constants::CATALOGUE_DBNAME,
            'user' => Constants::CATALOGUE_USER,
            'password' => Constants::CATALOGUE_PASSWORD,
            'host' => Constants::CATALOGUE_HOST,
            'driver' => 'pdo_mysql',
            'driverOptions' => array(
                1002 => 'SET NAMES utf8'
            )
        ])
    ->register('tecdoc',
        [
            'dbname' => Constants::TECDOC_DBNAME,
            'user' => Constants::TECDOC_USER,
            'password' => Constants::TECDOC_PASSWORD,
            'host' => Constants::TECDOC_HOST,
            'driver' => 'pdo_mysql',
            'charset'  => 'utf8',
            'driverOptions' => array(
                1002 => 'SET NAMES utf8'
            )
        ])
    ->register('grabber',
        [
            'dbname' => Constants::GRABBER_DBNAME,
            'user' => Constants::GRABBER_USER,
            'password' => Constants::GRABBER_PASSWORD,
            'host' => Constants::GRABBER_HOST,
            'driver' => 'pdo_mysql',
            'charset'  => 'utf8',
            'driverOptions' => array(
                1002 => 'SET NAMES utf8'
            )
        ]);

$container->add('DbConnectionManager', $dbConnectionManager, Container::MANAGER);