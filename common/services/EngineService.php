<?php
namespace common\services;

use core\Service\ServiceAbstract;

use common\repositories\Filter\EngineFilter;
use common\repositories\EngineRepository;

class EngineService extends ServiceAbstract
{
    const ENGINES_LIMIT = 300;

    /**
     * @var EngineRepository
     */
    public $engineRepository;

    /**
     * BrandService constructor.
     * @param EngineRepository $engineRepository
     */
    public function __construct(EngineRepository $engineRepository)
    {
        $this->engineRepository = $engineRepository;
    }

    /**
     * @param int $modelId
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getEnginesByModelId(int $modelId = 0) : array
    {
        if ($modelId === 0) {
            throw new \InvalidArgumentException('modelId is required param');
        }

        $filter = new EngineFilter(self::ENGINES_LIMIT);
        $filter
            ->setModelId($modelId)
            ->setOrderBy('engine', 'ASC');

        return $this->getEngineRepository()->findByFilter($filter);
    }

    public function getEngineRepository(): EngineRepository
    {
        return $this->engineRepository;
    }
}