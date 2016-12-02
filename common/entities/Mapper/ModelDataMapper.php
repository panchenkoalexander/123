<?php
namespace common\entities\Mapper;

use core\Interfaces\DataMapperInterface;
use core\Interfaces\EntityInterface;

use common\entities\Model;

class ModelDataMapper implements DataMapperInterface
{
    /**
     * @param Model $model
     * @return array
     */
    public function entityToRow(EntityInterface $model) : array
    {
        return [
            'id' => $model->getId(),
            'name' => $model->getName(),
            'brandId' => $model->getBrandId(),
        ];
    }

    /**
     * @param array $entityData
     * @return Model
     */
    public function rowToEntity(array $modelData) : EntityInterface
    {
        $model = new Model();
        $model->setId($modelData['id']);
        $model->setName($modelData['name']);
        $model->setBrandId($modelData['brandId']);

        return $model;
    }
}