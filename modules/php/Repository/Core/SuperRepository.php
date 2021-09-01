<?php

namespace Linko\Repository\Core;

use Linko\Models\Core\Field;
use Linko\Serializers\Core\Serializer;
use Linko\Tools\DBRequester;
use Linko\Tools\QueryBuilder;

/**
 * Description of SuperRepository
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperRepository implements Repository {

    /**

     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var DBRequester
     */
    protected $dbRequester;
    protected $serializer;
    protected $fields;

    /**
     * 
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder {
        if (null === $this->queryBuilder) {
            $this->queryBuilder = new QueryBuilder();
        }
        return $this->queryBuilder;
    }

    public function getDbRequester(): DBRequester {
        if (null === $this->dbRequester) {
            $this->dbRequester = new DBRequester();
        }

        return $this->dbRequester;
    }

    /**
     * 
     * @return Serializer
     */
    public function getSerializer(): Serializer {
        return $this->serializer;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Fields Management
     * ---------------------------------------------------------------------- */

    abstract public function getTableName();

    abstract public function getFieldsPrefix();

    final public function getFields() {
        return $this->fields;
    }

    /**
     * 
     * @return Field
     */
    public function getPrimaryField() {
        $fields = $this->getFields();
        foreach ($fields as $field) {
            if ($field->isPrimary()) {
                return $field;
            }
        }

        return;
    }

    /**
     * get all DBFields
     * @return array all DBFields
     */
    public function getDbFields() {
        $res = [];
        $fields = $this->getFields();
        foreach ($fields as $field) {
            $res [] = $this->getFieldsPrefix() . $field->getProperty();
        }
        return $res;
    }

    /**
     * get all UIFields (usfull for display)
     * @return array all DBFields
     */
    public function getUiFields() {
        $res = new ArrayCollection();
        $fields = $this->getFields();
        foreach ($fields as $field) {
            if ($field->isUi()) {
                $res->add($field);
            }
        }
        return $res;
    }

    /**
     * 
     * @param string $property
     * @return Field
     */
    public function getFieldByProperty($property) {
        foreach ($this->getFields() as $field) {
            if ($property === $field->getProperty()) {
                return $field;
            }
        }
        return;
    }

    /**
     * 
     * @param string $dbName
     * @return Field
     */
    public function getFieldByDB($dbName) {
        foreach ($this->getFields() as $field) {
            if ($dbName === $field->getDb()) {
                return $field;
            }
        }
        return;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement Base queries
     * ---------------------------------------------------------------------- */

    public function getAll() {



        return $this->getQueryBuilder()
                        ->select();
    }

    public function getById($id) {
        return $this->getQueryBuilder()->findByPrimary($id);
    }

    public function create($items) {
        return $this->getQueryBuilder()
                        ->insert($items)
                        ->execute();
    }

    public function update($model, $updField = null) {
        return $this->getQueryBuilder()
                        ->update($model, $updField)
                        ->execute();
    }

}

//-- OLD
//
//
//
//
//    /**
//     * Execute select 
//     * @return ArrayCollection
//     */
//    private function executeInsert() {
//        self::DbQuery($this->queryString);
//        return self::DbGetLastId();
//    }
//
//    /* -------------------------------------------------------------------------
//     *                  BEGIN - UPDATE
//     * ---------------------------------------------------------------------- */
//
//
//    private function perpareUpdate() {
//        $this->queryString = self::TYPE_UPDATE . " ";
//        $this->queryString .= "`" . $this->repository->getTableName() . "`";
//
//        if (null === $this->fields) {
//            $this->fields = $this->repository->getFields();
//        }
//
//        return $this;
//    }
//
//    private function prepareSetter() {
//        $primary = $this->repository->getPrimaryField();
//        $this->setters = [];
//
//        $this->queryString .= " SET ";
//        if (is_array($this->items)) {
//            //-- Only need one serie of fields
//            $raw = $this->repository->getSerializer()->serialize($this->items[0], $this->fields);
//        } else {
//            $raw = $this->repository->getSerializer()->serialize($this->items, $this->fields);
//        }
//
//
//        if (isset($raw[$primary->getDb()])) {
//            unset($raw[$primary->getDb()]);
//        }
//
//        $this->setters = [];
//        foreach ($raw as $dbField => $value) {
//            $field = $this->repository->getFieldByDB($dbField);
//            $setter = "`" . $dbField . "` = ";
//            $setter .= $this->fieldTransposer->transpose($value, $field);
//            $this->setters[] = $setter;
//        }
//
//        $this->queryString .= implode(",", $this->setters);
//
//        return $this;
//    }
//
//    private function executeUpdate() {
//        self::DbQuery($this->queryString);
//        return self::DbAffectedRow();
//    }
//
//    /* -------------------------------------------------------------------------
//     *                  BEGIN - Select Queries
//     * ---------------------------------------------------------------------- */
//
//    public function getAll() {
//        return $this->select()->execute();
//    }
//
//    public function findByPrimary($id) {
//        $primary = $this->repository->getPrimaryField();
//
//        $this->select()
//                ->addWhere($primary, $id);
//
//        return $this->select()
//                        ->addWhere($primary, $id)
//                        ->execute();
//    }