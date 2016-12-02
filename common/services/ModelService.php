<?php
namespace common\services;

use core\Service\ServiceAbstract;

use common\repositories\Filter\ModelFilter;
use common\repositories\ModelRepository;

class ModelService extends ServiceAbstract
{
    /**
     * @const int
     */
    const MODELS_LIMIT = 300;

    /**
     * @var ModelRepository
     */
    public $modelRepository;

    /**
     * BrandService constructor.
     * @param ModelRepository $modelRepository
     */
    public function __construct(ModelRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
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

        $filter = new ModelFilter(self::MODELS_LIMIT);
        $filter
            ->setBrandId($brandId)
            ->setOrderBy('name', 'ASC');

        return $this->getModelRepository()->findByFilter($filter);
    }

    public function getModelRepository(): ModelRepository
    {
        return $this->modelRepository;
    }
}