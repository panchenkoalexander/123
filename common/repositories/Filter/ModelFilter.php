<?php
namespace common\repositories\Filter;

use core\Repository\Filter\FilterAbstract;

class ModelFilter extends FilterAbstract
{
    private $id;

    private $brandId;

    private $name;

    /**
     * @return int[]
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int[] ...$id
     * @return $this
     */
    public function setId(int ...$id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int[]
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * @param int[] ...$brandId
     * @return $this
     */
    public function setBrandId(int ...$brandId)
    {
        $this->brandId = $brandId;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string[] $name
     * @return $this
     */
    public function setName(string ...$name)
    {
        $this->name = $name;

        return $this;
    }
}