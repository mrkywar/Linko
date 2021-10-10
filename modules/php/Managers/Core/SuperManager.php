<?php

namespace Linko\Managers\Core;

use Linko\Serializers\Serializer;
use Linko\Tools\DB\DBRequester;
use Linko\Tools\DB\DBTableRetriver;
use Linko\Tools\DB\Fields\DBFieldsRetriver;
use Linko\Tools\DB\Fields\DBFiledsFilter;
use Linko\Tools\DB\QueryBuilder;
use Linko\Tools\DB\QueryString;

/**
 * Description of SuperManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperManager extends DBRequester {

    /**
     * 
     * @var Serializer
     */
    private $serializer;

    /* -------------------------------------------------------------------------
     *                  BEGIN - SERIALIZER
     * ---------------------------------------------------------------------- */

    /**
     * @return Serializer
     */
    public function getSerializer(): Serializer {
        if (null === $this->serializer) {
            $this->serializer = $this->initSerializer();
        }
        return $this->serializer;
    }

    /**
     * @return Serializer
     */
    abstract protected function initSerializer();

    /* -------------------------------------------------------------------------
     *                  BEGIN - Fields Retrive Methods (protected/private)
     * ---------------------------------------------------------------------- */

    final private function getItems($items = null) {
        if (null === $items) {
            $className = $this->getSerializer()->getClassModel();
            $items = new $className();
        }
        return $items;
    }

    final protected function getInsertFields($items) {
        return DBFieldsRetriver::retriveInsertFields($items);
    }

    final protected function getSeletFields() {
        return DBFieldsRetriver::retriveSelectFields($this->getItems());
    }

    final protected function getPrimaryFields($items) {
        return DBFieldsRetriver::retrivePrimaryFields($items);
    }

    final protected function getFieldByProperty(string $propertyName, $items = null) {
        return DBFieldsRetriver::retriveFieldByPropertyName($propertyName, $this->getItems($items));
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Table Retrive Methods (protected)
     * ---------------------------------------------------------------------- */

    final protected function getTable($items = null) {
        if (null === $items) {
            $className = $this->getSerializer()->getClassModel();
            $items = new $className();
        }
        return DBTableRetriver::retrive($items);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Generic methods
     * ---------------------------------------------------------------------- */

    protected function create($items) {
        $fields = $this->getInsertFields($items);
        $table = $this->getTable($items);

        $qb = new QueryBuilder();
        $qb->setTable($table)
                ->insert()
                ->setFields($fields)
                ->setValues($items);

        $this->execute($qb);
    }

    protected function getAll($limit = null) {
        $fields = $this->getSeletFields();
        $table = $this->getTable();

        $qb = new QueryBuilder();

        $qb->setTable($table)
                ->select()
                ->setFields($fields);

        if (null !== $limit) {
            $qb->setLimit($limit);
        }

        return $this->execute($qb);
    }

}
