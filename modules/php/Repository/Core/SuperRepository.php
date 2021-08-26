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
    final public function getSerializer(): Serializer {
        return $this->serializer;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Fields Management
     * ---------------------------------------------------------------------- */

    abstract public function getFields();

    abstract public function getTableName();

    abstract public function getFieldsPrefix();

    public function getDbFields() {
        $res = [];
        $fields = $this->getFields();
        foreach ($fields as $fieldName) {
            $res [] = $this->getFieldsPrefix() . $fieldName;
        }
        return $res;
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
