<?php
/**
 * Config file for services
 */

use core\Common\Container\Container;

use common\services\BrandService;
use common\services\ModelService;
use common\services\EngineService;

/**
 * @var Container $container
 */
$container = \Yii::$app->container;

$brandService = function (Container $c) {
    return new BrandService(
        $c->get('BrandRepository')
    );
};

$container->add('BrandService', $brandService, Container::SERVICE);

$modelService = function (Container $c) {
    return new ModelService(
        $c->get('ModelRepository')
    );
};

$container->add('ModelService', $modelService, Container::SERVICE);

$engineService = function (Container $c) {
    return new EngineService(
        $c->get('EngineRepository')
    );
};

$container->add('EngineService', $engineService, Container::SERVICE);