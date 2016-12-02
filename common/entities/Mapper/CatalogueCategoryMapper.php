<?php
namespace common\entities\Mapper;

use core\Interfaces\DataMapperInterface;
use core\Interfaces\EntityInterface;

use common\entities\CatalogueCategory;


class CatalogueCategoryMapper implements DataMapperInterface
{
    /**
     * @param CatalogueCategory $category
     * @return array
     */
    public function entityToRow(EntityInterface $category) : array
    {
        return [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'hasChild' => $category->getHasChild(),
        ];
    }

    /**
     * @param array $categoryData
     * @return CatalogueCategory
     */
    public function rowToEntity(array $categoryData) : EntityInterface
    {
        $category = new CatalogueCategory();
        $category->setId($categoryData['id']);
        $category->setName($categoryData['name']);
        $category->setHasChild($categoryData['hasChild']);

        return $category;
    }
}