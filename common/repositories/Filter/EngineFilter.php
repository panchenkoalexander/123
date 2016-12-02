<?php
namespace common\repositories\Filter;

use core\Repository\Filter\FilterAbstract;

class EngineFilter extends FilterAbstract
{
    private $id;

    private $modelId;

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
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * @param int[] ...$modelId
     * @return $this
     */
    public function setModelId(int ...$modelId)
    {
        $this->modelId = $modelId;

        return $this;
    }
}