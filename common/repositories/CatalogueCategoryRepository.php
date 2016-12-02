<?php
namespace common\repositories;

use core\datamanager\EntityInterface;
use core\datamanager\MapperInterface;
use core\datamanager\RepositoryInterface;

use common\entities\mappers\CatalogueCategoryMapper;

class CatalogueCategoryRepository implements RepositoryInterface
{
    /**
     * @var CatalogueCategoryMapper
     */
    protected $mapper;

    public function __construct()
    {
        $this->mapper = new CatalogueCategoryMapper();
    }

    public function findByPk() : EntityInterface
    {
        // TODO: Implement findByPk() method.
    }

    public function findOne(array $conditions) : EntityInterface
    {
        // TODO: Implement findOne() method.
    }

    public function findAll() : array
    {

    }

    public function findByCondition(array $conditions) : array
    {
        // TODO: Implement findByCondition() method.
    }

    /**
     * @return CatalogueCategoryMapper
     */
    public function getMapper() : MapperInterface
    {
        return $this->mapper;
    }
}