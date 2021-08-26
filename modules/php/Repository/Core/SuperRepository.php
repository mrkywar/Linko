<?php

namespace Linko\Repository\Core;

use Linko\Serializers\Core\Serializer;
use Linko\Tools\QueryBuilder;

/**
 * Description of SuperRepository
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperRepository implements Repository {

    /**
     * 
     * @var QueryBuilder
     */
    protected $queryBuilder;
    protected $serializer;

    /**
     * 
     * @return QueryBuilder
     */
    public function getQueryBuilder() {
        if (null === $this->queryBuilder) {
            $this->queryBuilder = new QueryBuilder($this);
        }
        return $this->queryBuilder;
    }

    /**
     * 
     * @return Serializer
     */
    public function getSerializer(): Serializer {
        return $this->serializer;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement Base queries
     * ---------------------------------------------------------------------- */

    public function getAll() {
        return $this->getQueryBuilder()->getAll();
    }

    public function create($items) {
        return $this->getQueryBuilder()->create($items);
    }

}
