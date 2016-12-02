<?php
/**
 * Config file for repositories
 */

use core\Common\ConnectionManager\Manager\DbConnectionManager;
use core\Common\Container\Container;

use common\entities\Mapper\BrandDataMapper;
use common\entities\Mapper\ModelDataMapper;
use common\entities\Mapper\EngineDataMapper;
use common\repositories\BrandRepository;
use common\repositories\ModelRepository;
use common\repositories\EngineRepository;

/**
 * @var Container $container
 */
$container = \Yii::$app->container;

$brandRepository = $container->factory(function (Container $c) {
    /**
     * @var DbConnectionManager $dbConnectionManager
     */
    $dbConnectionManager = $c->get('DbConnectionManager');
    $connection = $dbConnectionManager->getConnection('catalogue');
    $dataMapper = new BrandDataMapper();

    return new BrandRepository(
        $connection,
        $dataMapper,
        'brand',
        'id'
    );
});

$container->add('BrandRepository', $brandRepository, Container::REPOSITORY);

$modelRepository = $container->factory(function (Container $c) {
    /**
     * @var DbConnectionManager $dbConnectionManager
     */
    $dbConnectionManager = $c->get('DbConnectionManager');
    $connection = $dbConnectionManager->getConnection('catalogue');
    $dataMapper = new ModelDataMapper();

    return new ModelRepository(
        $connection,
        $dataMapper,
        'model',
        'id'
    );
});

$container->add('ModelRepository', $modelRepository, Container::REPOSITORY);

$engineRepository = $container->factory(function (Container $c) {
    /**
     * @var DbConnectionManager $dbConnectionManager
     */
    $dbConnectionManager = $c->get('DbConnectionManager');
    $connection = $dbConnectionManager->getConnection('catalogue');
    $dataMapper = new EngineDataMapper();

    return new EngineRepository(
        $connection,
        $dataMapper,
        'engine',
        'id'
    );
});

$container->add('EngineRepository', $engineRepository, Container::REPOSITORY);
