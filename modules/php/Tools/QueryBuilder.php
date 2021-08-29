<?php

namespace Linko\Tools;

use Linko\Models\Core\Field;
use Linko\Models\Model;
use Linko\Repository\Core\Repository;

/**
 * Description of QueryBuilder
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class QueryBuilder extends \APP_DbObject {

    const TYPE_SELECT = "SELECT";
    const TYPE_INSERT = "INSERT";
    const TYPE_UPDATE = "UPDATE";
    const ORDER_ASC = "ASC";
    const ORDER_DESC = "DESC";

    /**
     * @var array
     */
    private $conditions = [];

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var DBFieldTransposer
     */
    private $fieldTransposer;

    /**
     * @var array
     */
    private $orderBy = [];

    /**
     * @var string
     */
    private $sql;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var array
     */
    private $setters = [];

    public function __construct(Repository $repository) {
        $this->repository = $repository;
        $this->fieldTransposer = new DBFieldTransposer($this->repository);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Execute Queries
     * ---------------------------------------------------------------------- */

    public function execute() {

        $queryType = substr($this->sql, 0, strpos($this->sql, " "));

        switch ($queryType) {
            case self::TYPE_SELECT:
                return $this->prepareConditions()
                                ->prepareOrderBy()
                                ->prepareLimit()
                                ->executeSelect();
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

    public function preapareSelect() {
        $this->sql = self::TYPE_SELECT . " * FROM ";
        $this->sql .= $this->repository->getTableName();
        return $this;
    }

    public function getAll() {
        return $this->preapareSelect()->execute();
    }

    public function findByPrimary($id) {
        $primary = $this->repository->getPrimaryField();
        return $this->preapareSelect()
                        ->addWhere($primary, $id)
                        ->execute();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Conditions (WHERE)
     * ---------------------------------------------------------------------- */

    private function prepareConditions() {
        $iteration = 0;
        foreach ($this->conditions as $condition) {
            $this->sql .= (0 === $iteration) ? " WHERE " : " AND ";
            $this->sql .= $condition;
            $iteration++;
        }
        return $this;
    }

    public function addWhere(Field $field, $value) {
        $condition = "`" . $field->getDb() . "`";
        if (is_array($value)) {
            $transposed = [];
            foreach ($value as $val) {
                $transposed [] = $this->sql .= $this->fieldTransposer->transpose($val, $field);
            }
            $condition .= " IN (" . implode(",", $transposed) . ")";
        } else {
            $condition .= " = " . $this->fieldTransposer->transpose($value, $field);
        }

        $this->conditions[] = $condition;

        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Ordering
     * ---------------------------------------------------------------------- */

    public function addOrderBy(Field $field, $dir = self::ORDER_ASC) {
        $this->orderBy[] = $field->getDb() . " " . $dir;
        return $this;
    }

    private function prepareOrderBy() {
        if (sizeof($this->orderBy) > 0) {
            $this->sql .= " ORDER BY " . implode(",", $this->orderBy);
        }
        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Limit
     * ---------------------------------------------------------------------- */

    public function setLimit(int $limit) {
        $this->limit = $limit;
        return $this;
    }

    private function prepareLimit() {
        if (null !== $this->limit) {
            $this->sql .= " LIMIT " . $this->limit;
        }
        return $this;
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

    /**
     * Create new item(s) of Model
     * @param Model|ArrayCollection<Model> $items item(s) to create
     */
    public function create($items) {
        $this->prepareInsert($items)->execute();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - UPDATE
     * ---------------------------------------------------------------------- */

    public function update(Model $model) {
        $this->sql = self::TYPE_UPDATE;
        $this->sql .= " `" . $this->repository->getTableName() . "` ";

        $raw = $this->repository->getSerializer()->serialize($model, $this->repository->getFields());
        $primary = $this->repository->getPrimaryField();
        
        echo '<pre>--';
        var_dump($raw,$model);
        unset($raw[$primary->getDb()]);
        
        var_dump($raw);die;
    }

}
