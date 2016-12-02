<?php
namespace common\entities\Mapper;

use core\Interfaces\DataMapperInterface;
use core\Interfaces\EntityInterface;

use common\entities\Engine;

class EngineDataMapper implements DataMapperInterface
{
    /**
     * @param Engine $engine
     * @return array
     */
    public function entityToRow(EntityInterface $engine) : array
    {
        return [
            'id' => $engine->getId(),
            'name' => $engine->getEngine(),
            'modelId' => $engine->getModelId(),
            'engine' => $engine->getEngine(),
            'year' => $engine->getYear(),
            'horsePower' => $engine->getHorsePower(),
        ];
    }

    /**
     * @param array $engineData
     * @return Engine
     */
    public function rowToEntity(array $engineData) : EntityInterface
    {
        $engine = new Engine();
        $engine->setId($engineData['id']);
        $engine->setEngine($engineData['engine']);
        $engine->setModelId($engineData['modelId']);
        $engine->setYear($engineData['year']);
        $engine->setHorsePower($engineData['horsePower']);

        return $engine;
    }
}