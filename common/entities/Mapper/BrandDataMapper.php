<?php
namespace common\entities\Mapper;

use core\Interfaces\DataMapperInterface;
use core\Interfaces\EntityInterface;

use common\entities\Brand;

class BrandDataMapper implements DataMapperInterface
{
    /**
     * @param Brand $brand
     * @return array
     */
    public function entityToRow(EntityInterface $brand) : array
    {
        return [
            'id' => $brand->getId(),
            'name' => $brand->getName(),
        ];
    }

    /**
     * @param array $entityData
     * @return Brand
     */
    public function rowToEntity(array $brandData) : EntityInterface
    {
        $brand = new Brand();
        $brand->setId($brandData['id']);
        $brand->setName($brandData['name']);

        return $brand;
    }
}