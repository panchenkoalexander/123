<?php
namespace common\repositories;

use common\repositories\Filter\BrandFilter;
use core\Repository\RepositoryAbstract;

class BrandRepository extends RepositoryAbstract
{
    /**
     * @const int
     */
    const BRANDS_LIMIT = 300;

    /**
     * @return array
     */
    public function findAll() : array
    {
        $filter = new BrandFilter(self::BRANDS_LIMIT);
        $filter->setOrderBy('name', 'ASC');

        return $this->findByFilter($filter);
    }
}