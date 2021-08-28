<?php

namespace Linko\Tools;

use Linko\Repository\Core\Repository;

/**
 * Description of QueryBuilder
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class QueryBuilder extends \APP_DbObject {

    const TYPE_SELECT = "SELECT";
    const TYPE_INSERT = "INSERT";

    private $conditions;
    private $repository;
    private $fieldTransposer;
    private $sql;

    public function __construct(Repository $repository) {
        $this->conditions = new ArrayCollection();
        $this->repository = $repository;
        $this->fieldTransposer = new DBFieldTransposer($this->repository);
    }

    private function execute() {
        $queryType = substr($this->sql, 0, strpos($this->sql, " "));
//        var_dump($queryType, $this->sql);
//        die;

        switch ($queryType) {
            case self::TYPE_SELECT:
                return $this->executeSelect();
            case self::TYPE_INSERT:
                self::DbQuery($this->sql);
                return self::DbGetLastId();
        }
    }

    private function executeSelect() {
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
        $this->sql = self::TYPE_SELECT . " * FROM ";
        $this->sql .= $this->repository->getTableName();
        return $this;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getAll() {
        return $this->preapareSelect()->execute();
    }

    public function findByPrimary($id) {
        $this->prepareSelect();
        $primary = $this->repository->getPrimaryField();
        $this->sql .= " WHERE `" . $primary->getDB() . "` ";
        if (is_array($id)) {
            $transposed = [];
            foreach ($id as $sid) {
                $transposed [] = $this->sql .= $this->fieldTransposer->transpose($sid, $primary);
            }
            $this->sql .= " IN (" . implode(",", $transposed) . ")";
        } else {
            $this->sql .= " = ";
            $this->sql .= $this->fieldTransposer->transpose($id, $primary);
        }
        $this->sql .= $this->fieldTransposer->transpose($id, $primary);

        return $this->execute();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - INSERT
     * ---------------------------------------------------------------------- */

    private function prepareValues($raw) {
        $values = [];
        foreach ($this->repository->getFields() as $field) {
            if (isset($raw[$field->getDB()])) {
                $values[] = $this->fieldTransposer->transpose($raw[$field->getDB()], $field);
            } else {
                $values[] = "null";
            }
        }
        return "(" . implode(",", $values) . ")";
    }

    private function prepareInsert($items) {
        $fields = implode(', ', $this->repository->getDbFields());
        $table = $this->repository->getTableName();

        $this->sql = self::TYPE_INSERT . " INTO";
        $this->sql .= " `" . $table . "` ";
        $this->sql .= "( " . $fields . ")";
        $this->sql .= " VALUES ";

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
        $this->prepareInsert($items)->execute();
    }

}
