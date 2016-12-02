<?php
namespace common\services;

use core\Service\ServiceAbstract;

use common\repositories\BrandRepository;

class BrandService extends ServiceAbstract
{
    /**
     * @var BrandRepository
     */
    public $brandRepository;

    /**
     * BrandService constructor.
     * @param BrandRepository $brandRepository
     */
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * @return array
     */
    public function getBrands()
    {
        return $this->brandRepository->findAll();
    }

    /**
     * @return BrandRepository
     */
    public function getBrandRepository(): BrandRepository
    {
        return $this->brandRepository;
    }
}