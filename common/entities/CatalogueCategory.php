<?php
namespace common\entities;

use core\Interfaces\EntityInterface;

class CatalogueCategory implements EntityInterface
{
    protected $id;

    protected $name;

    protected $hasChild;

    /**
     * @return mixed
     */
    public function getHasChild()
    {
        return $this->hasChild;
    }

    /**
     * @param mixed $hasChild
     */
    public function setHasChild($hasChild)
    {
        $this->hasChild = $hasChild;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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