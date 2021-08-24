<?php

namespace Linko\Tools;

use Linko\Repository\PlayerRepository;
use Linko\Repository\Repository;

/**
 * Description of QueryBuilder
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class QueryBuilder extends \APP_DbObject {

    private $conditions;
    private $repository;
    private $fieldTransposer;
    //private $typeOfQuery;
    private $sql;

    public function __construct(Repository $repository) {
        $this->conditions = new ArrayCollection();
        $this->repository = $repository;
        $this->fieldTransposer = new DBFieldTransposer($this->repository);
    }

    private function execute() {
        $results = self::getObjectListFromDB($this->sql);

        switch (sizeof($results)) {
            case 0:
                return null;
            case 1:
                return $this->repository->getSerializer()->unserialize($results[0]);
            default :
                $col = new ArrayCollection();
                foreach ($results as $res) {
                    $col->add($this->repository->getSerializer()->unserialize($res));
                }
                return $col;
        }
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - SELECT
     * ---------------------------------------------------------------------- */

    private function preapareSelect() {
        $this->sql = "SELECT * FROM " . $this->repository->getTableName();
        return $this;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getAll() {
        return $this->preapareSelect()->execute();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - INSERT
     * ---------------------------------------------------------------------- */

    private function prepareValues($raw) {
        $values = [];
        foreach ($this->repository->getFields() as $fieldName) {
            $field = $this->repository->getFieldsPrefix() . $fieldName;
            if (isset($raw[$field])) {
                $values[] = $this->fieldTransposer->transpose($raw[$field], $fieldName);
            } else {
                $values[] = "null";
            }
        }
        return "(" . implode(",", $values) . ")";
    }

    private function prepareInsert($items) {
        $this->sql = "INSERT INTO " . $this->repository->getTableName() . " ";
        $this->sql .= implode(",", $this->repository->getFields()) . " ";
        $this->sql .= "VALUES ";

        $serializer = $this->repository->getSerializer();
        if ($items instanceof ArrayCollection) {
            //multiple
            $raws = [];
            foreach ($items as $item) {
                $raw = $serializer->serialize($item, $this->repository->getFields());
                $raws[] = $this->prepareValues($raw);
            }

            $this->sql .= implode(",", $raws);
        } else {
            //single
            $raw = $serializer->serialize($items, $this->repository->getFields());
            $this->sql .= $raw;
        }

        return $this;
    }

    public function create($items) {
        $this->prepareInsert($items);
        var_dump($this->sql);die;
        
        return $this->prepareInsert($items)->execute();
    }

}
