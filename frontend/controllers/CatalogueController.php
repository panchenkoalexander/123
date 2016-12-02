<?php
namespace frontend\controllers;

use common\components\Catalogue;
use Yii;

use common\controllers\BaseController;

/**
 * Catalogue controller
 */
class CatalogueController extends BaseController
{
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
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        echo \Yii::$app->request->get('brand');
        echo \Yii::$app->request->get('model');
        echo \Yii::$app->request->get('engine');
        $engineId = \Yii::$app->request->get('engineId');

        $categories = \Yii::$app->catalogue->getEngineCategories($engineId);

        $brands = $this->catalogue->getBrands();
        $convertedBrands = [];
        foreach ($brands as $brand) {
            $firstLetter = ucfirst($brand->getName()[0]);
            if (!isset($convertedBrands[$firstLetter])) {
                $convertedBrands[$firstLetter] = [];
            }

            $convertedBrands[$firstLetter][] = $brand;
        }
        return $this->render(
            'index',
            [
                'convertedBrands' => $convertedBrands,
                'categories' => $categories
            ]
        );
    }

    public function actionBrands() {
        $brands = $this->catalogue->getBrands();
    }

    public function actionModels() {
        $brandId = \Yii::$app->request->get('brandId');

        if (!$brandId) {
            throw new \InvalidArgumentException('brandId is missing');
        }

        $models = $this->catalogue->getModelsByBrandId($brandId);

        $data = $this->renderPartial(
            'models',
            [
                'models' => $models
            ]
        );

        echo $this->responseSuccess($data);
    }

    public function actionEngines() {
        $modelId = \Yii::$app->request->get('modelId');

        if (!$modelId) {
            throw new \InvalidArgumentException('modelId is missing');
        }

        $engines = $this->catalogue->getEnginesByModelId($modelId);

        $data = $this->renderPartial(
            'engines',
            [
                'engines' => $engines
            ]
        );

        echo $this->responseSuccess($data);
    }
}
