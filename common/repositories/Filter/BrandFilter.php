<?php
namespace common\repositories\Filter;

use core\Repository\Filter\FilterAbstract;

class BrandFilter extends FilterAbstract
{
    private $id;

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