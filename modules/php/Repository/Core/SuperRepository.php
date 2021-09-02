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
     * @var DBRequester
     */
    protected $dbRequester;
    protected $serializer;
    protected $fields;

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

    /**
     * 
     * @return QueryBuilder
     */
    public function getQueryBuilder() {
        $qb = new QueryBuilder();
        $qb->setTableName($this->getTableName());
        return $qb;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Fields Management
     * ---------------------------------------------------------------------- */

    abstract public function getTableName();

    abstract public function getFieldsPrefix();

    final public function getFields() {
        return $this->fields;
    }
    
    final public function setFields(array $fields) {
        $this->fields = $fields;
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
        $qb = $this->getQueryBuilder()->select();

        return $this->dbRequester->execute($qb);
    }

    public function getById($id) {
        $qb = $this->getQueryBuilder()
                ->select()
                ->addClause($this->getPrimaryField(), $id);

        return $this->dbRequester->execute($qb);
    }

    public function create($items) {
        $qb = $this->getQueryBuilder()
                ->insert();
        
        if(is_array($items)){
            foreach ($items as $item){
                $qb->addValue($item);
            }
        }else{
            $qb->addValue($items);
        }
        
        return $this->dbRequester->execute($qb); 
    }

}
