<?php
namespace common\entities\Mapper;

use core\Interfaces\DataMapperInterface;
use core\Interfaces\EntityInterface;

use common\entities\Product;

class ProductDataMapper implements DataMapperInterface
{
    /**
     * @param Product $product
     * @return array
     */
    public function entityToRow(EntityInterface $product) : array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
        ];
    }

    /**
     * @param array $entityData
     * @return Product
     */
    public function rowToEntity(array $productData) : EntityInterface
    {
        $product = new Product();
        $product->setId($productData['id']);
        $product->setName($productData['name']);

        return $product;
    }
}