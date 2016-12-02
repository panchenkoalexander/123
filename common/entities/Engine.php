<?php
namespace common\entities;

use core\Interfaces\EntityInterface;

class Engine implements EntityInterface
{
    protected $id;

    protected $modelId;

    protected $engine;

    protected $year;

    protected $horsePower;

    /**
     * @return mixed
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * @param mixed $modelId
     */
    public function setModelId($modelId)
    {
        $this->modelId = $modelId;
    }

    /**
     * @return mixed
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param mixed $engine
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getHorsePower()
    {
        return $this->horsePower;
    }

    /**
     * @param mixed $horsePower
     */
    public function setHorsePower($horsePower)
    {
        $this->horsePower = $horsePower;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}