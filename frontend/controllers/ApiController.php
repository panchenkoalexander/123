<?php
namespace frontend\controllers;

use core\Interfaces\DataMapperInterface;
use Yii;

use core\Common\Container\Container;

use common\controllers\BaseController;
use common\components\Catalogue;
use common\services\ModelService;
use common\services\BrandService;
use common\services\EngineService;

/**
 * Catalogue controller
 */
class ApiController extends BaseController
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var BrandService
     */
    protected $brandService;

    /**
     * @var ModelService
     */
    protected $modelService;

    /**
     * @var EngineService
     */
    protected $engineService;

    /**
     * @var Catalogue
     */
    protected $catalogue;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function init()
    {
        parent::init();
        $this->catalogue = \Yii::$app->catalogue;
        $this->container = \Yii::$app->container;
        $this->brandService = $this->container->get('BrandService');
        $this->modelService = $this->container->get('ModelService');
        $this->engineService = $this->container->get('EngineService');
    }

    public function actionBrand()
    {
        try {
            $brands = $this->brandService->getBrands();
            $this->responseSuccess(
                $this->toResponseFormat(
                    $brands,
                    $this->brandService->getBrandRepository()->getDataMapper()
                )
            );
        } catch (\Exception $e) {
            $this->responseError($e->getMessage());
        }
    }

    public function actionModel()
    {
        try {
            $models = $this->modelService->getModelsByBrandId(
                (int) $this->getParam('brandId')
            );
            $this->responseSuccess(
                $this->toResponseFormat(
                    $models,
                    $this->modelService->getModelRepository()->getDataMapper()
                )
            );
        } catch (\Exception $e) {
            $this->responseError($e->getMessage());
        }
    }

    public function actionEngine()
    {
        try {
            $engines = $this->engineService->getEnginesByModelId(
                (int) $this->getParam('modelId')
            );
            $this->responseSuccess(
                $this->toResponseFormat(
                    $engines,
                    $this->engineService->getEngineRepository()->getDataMapper()
                )
            );
        } catch (\Exception $e) {
            $this->responseError($e->getMessage());
        }
    }

    public function actionCategory()
    {
        try {
            $categories = $this->catalogue->getCategoriesByEngineId(
                (int) $this->getParam('engineId'),
                (int) $this->getParam('categoryId')
            );
            $this->responseSuccess($categories);
        } catch (\Exception $e) {
            $this->responseError($e->getMessage());
        }
    }

    public function actionArticle()
    {
        try {
            $tecdoc = \Yii::$app->tecdoc;
            $articleIds = $tecdoc->getCategoryArticle(
                (int) $this->getParam('categoryId'),
                (int) $this->getParam('engineId')
            );

            if (count($articleIds) === 0) {
                $this->responseError('Something was wrong');
            }

            $articleIds = array_column($articleIds, 'article');
            $articles = $tecdoc->getArticleByIds(
                $articleIds
            );

            $this->responseSuccess($articles);
        } catch (\Exception $e) {
            $this->responseError($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @param DataMapperInterface $dataMapper
     * @return array
     */
    protected function toResponseFormat(array $data, DataMapperInterface $dataMapper) : array
    {
         return array_map(function ($object) use ($dataMapper) {
            return $dataMapper->entityToRow($object);
        }, $data);
    }
}
