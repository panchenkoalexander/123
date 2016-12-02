<?php
namespace common\components;

use yii\base\Component;

use common\repositories\BrandRepository;
use common\repositories\EngineRepository;
use common\repositories\ModelRepository;
use common\repositories\CatalogueCategoryRepository;

class Catalogue extends Component
{
    /**
     * @var BrandRepository
     */
    protected $brandRepository;

    /**
     * @var ModelRepository
     */
    protected $modelRepository;

    /**
     * @var EngineRepository
     */
    protected $engineRepository;

    /**
     * @var CatalogueCategoryRepository
     */
    protected $catalogueCategoryRepository;

    /**
     * @var Tecdoc
     */
    protected $tecdocService;

    public function __construct()
    {
//        $this->brandRepository = new BrandRepository();
//        $this->modelRepository = new ModelRepository();
//        $this->engineRepository = new EngineRepository();
        $this->catalogueCategoryRepository = new CatalogueCategoryRepository();
        $this->tecdocService = new Tecdoc();
    }

    /**
     * @return array
     */
    public function getBrands() : array
    {
        return $this->brandRepository->findAll();
    }

    /**
     * @param int $brandId
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getModelsByBrandId(int $brandId = 0) : array
    {
        if ($brandId === 0) {
            throw new \InvalidArgumentException('brandId is required param');
        }

        $sql = "SELECT
                    id,
                    name,
                    brand_id
                FROM model
                WHERE brand_id = :brandId
                ORDER BY name";
        $rows = \Yii::$app->catalogueDb
            ->createCommand($sql)
            ->bindValue(':brandId', $brandId, \PDO::PARAM_INT)
            ->queryAll();

        $models = [];
        foreach ($rows as $row) {
            $models[] = $this->getModelRepository()->getMapper()->toObject($row);
        }

        return $models;
    }

    /**
     * @param int $modelId
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getEnginesByModelId(int $modelId) : array
    {
        if (!$modelId) {
            throw new \InvalidArgumentException('modelId is required param');
        }
        $sql = "SELECT
                    id,
                    engine,
                    year,
                    horsePower,
                    model_id
                FROM engine
                WHERE model_id = :modelId
                ORDER BY engine";
        $rows = \Yii::$app->catalogueDb
            ->createCommand($sql)
            ->bindValue(':modelId', $modelId, \PDO::PARAM_INT)
            ->queryAll();

        $engines = [];
        foreach ($rows as $row) {
            $engines[] = $this->getEngineRepository()->getMapper()->toObject($row);
        }

        return $engines;
    }

    /**
     * @param int $engineId
     * @param int $categoryId
     * @throws \InvalidArgumentException
     * @return array
     */
    public function getCategoriesByEngineId(int $engineId, int $categoryId) : array
    {
        return $this->tecdocService->getCategoriesByEngineId($engineId, $categoryId);
        $categories = [];
        foreach ($rows as $row) {
            $categories[] = $this->getCatalogueCategoryRepository()->getMapper()->toObject($row);
        }

        return $categories;
    }

    /**
     * @return BrandRepository
     */
    public function getBrandRepository() : BrandRepository
    {
        return $this->brandRepository;
    }

    /**
     * @return ModelRepository
     */
    public function getModelRepository() : ModelRepository
    {
        return $this->modelRepository;
    }

    /**
     * @return EngineRepository
     */
    public function getEngineRepository() : EngineRepository
    {
        return $this->engineRepository;
    }

    /**
     * @return CatalogueCategoryRepository
     */
    public function getCatalogueCategoryRepository() : CatalogueCategoryRepository
    {
        return $this->catalogueCategoryRepository;
    }
}