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
     * @var Repository
     */
    private $repository;

    /**
     * @var DBFieldTransposer
     */
    private $fieldTransposer;

    /**
     * @var string
     */
    private $queryType;

    /**
     * @var string
     */
    private $queryString;
    /* -------------------------------------------------------------------------
     *                  BEGIN - Select Properties
     * ---------------------------------------------------------------------- */

    /**
     * @var array
     */
    private $conditions = [];

    /**
     * @var array
     */
    private $orderBy = [];

    /**
     * @var int
     */
    private $limit;
    /* -------------------------------------------------------------------------
     *                  BEGIN - Update Properties
     * ---------------------------------------------------------------------- */

    /**
     * @var array
     */
    private $setters = [];

    /* -------------------------------------------------------------------------
     *                  BEGIN - Create Properties
     * ---------------------------------------------------------------------- */
    private $items;

    public function __construct(Repository $repository) {
        $this->repository = $repository;
        $this->fieldTransposer = new DBFieldTransposer($this->repository);

        $this->init();
    }

    private function init() {
        $this->queryType = null;
        //-- Select 
        $this->conditions = [];
        $this->orderBy = [];
        $this->limit = null;
        //-- update
        $this->setters = [];
        //-- create
        $this->items = null;
    }

    public function getQueryType(): string {
        return $this->queryType;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Statement
     * ---------------------------------------------------------------------- */

    public function getStatement() {
        $this->prepareStatement();
        return $this->queryString;
    }

    private function prepareStatement() {
        switch ($this->getQueryType()) {
            case self::TYPE_SELECT:
                $this->preapareSelect()
                        ->prepareConditions()
                        ->prepareOrderBy()
                        ->prepareLimit();
                break;
            case self::TYPE_INSERT:
                $this->prepareInsert()
                        ->prepareValues();
                break;
        }
        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - SELECT
     * ---------------------------------------------------------------------- */

    /**
     * set type of query to select
     * @return $this
     */
    public function select() {
        $this->queryType = self::TYPE_SELECT;
        return $this;
    }

    private function preapareSelect() {
        $this->queryString = self::TYPE_SELECT . " * FROM ";
        $this->queryString .= $this->repository->getTableName();
        return $this;
    }

    public function execute() {
        $this->prepareStatement();

        switch ($this->getQueryType()) {
            case self::TYPE_SELECT:
                return $this->executeSelect();
            case self::TYPE_INSERT:
                return $this->executeInsert();
        }

        $this->init(); // reinitialize QueryBuilder;
    }

    /**
     * Execute select 
     * @return \Linko\Tools\ArrayCollection
     */
    private function executeSelect() {
        $results = self::getObjectListFromDB($this->queryString);

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
     *                  BEGIN - Conditions (WHERE)
     * ---------------------------------------------------------------------- */

    private function prepareConditions() {
        $iteration = 0;

        foreach ($this->conditions as $condition) {
            $this->queryString .= (0 === $iteration) ? " WHERE " : " AND ";
            $this->queryString .= $condition;
            $iteration++;
        }

        return $this;
    }

    public function addWhere(Field $field, $value) {
        $condition = "`" . $field->getDb() . "`";
        if (is_array($value)) {
            $transposed = [];
            foreach ($value as $val) {
                $transposed [] = $this->fieldTransposer->transpose($val, $field);
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
            $this->queryString .= " ORDER BY " . implode(",", $this->orderBy);
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
            $this->queryString .= " LIMIT " . $this->limit;
        }
        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - INSERT
     * ---------------------------------------------------------------------- */

    /**
     * set type of query to insert
     * @param Model|ArrayCollection<Model> $items item(s) to create
     * @return $this
     */
    public function insert($items = null) {
        $this->items = $items;
        $this->queryType = self::TYPE_INSERT;
        return $this;
    }

    private function prepareInsert() {
        $table = $this->repository->getTableName();
        $fields = implode(', ', $this->repository->getDbFields());

        $this->queryString = self::TYPE_INSERT . " INTO ";
        $this->queryString .= " `" . $table . "` ";
        $this->queryString .= "( " . $fields . ")";
        $this->queryString .= " VALUES ";

        return $this;
    }

    private function prepareValues() {

        $raws = [];
        $serializer = $this->repository->getSerializer();

        foreach ($this->items as $item) {
            $raw = $serializer->serialize($item, $this->repository->getFields());
            $values = [];
            foreach ($this->repository->getFields() as $field) {
                if (isset($raw[$field->getDB()])) {
                    $values[] = $this->fieldTransposer->transpose($raw[$field->getDB()], $field);
                } else {
                    $values[] = "null";
                }
            }

            $raws [] = "(" . implode(",", $values) . ")";
        }

        $this->queryString .= implode(",", $raws);

        return $this;
    }

    /**
     * Execute select 
     * @return \Linko\Tools\ArrayCollection
     */
    private function executeInsert() {
        self::DbQuery($this->queryString);
        return self::DbGetLastId();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Select Queries
     * ---------------------------------------------------------------------- */

    public function getAll() {
        return $this->select()->execute();
    }

    public function findByPrimary($id) {
        $primary = $this->repository->getPrimaryField();

        $this->select()
                ->addWhere($primary, $id);

        return $this->select()
                        ->addWhere($primary, $id)
                        ->execute();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - UPDATE
     * ---------------------------------------------------------------------- */

    public function update(Model $model) {
        $this->sql = self::TYPE_UPDATE;
        $this->sql .= " `" . $this->repository->getTableName() . "` ";

        $raw = $this->repository->getSerializer()->serialize($model, $this->repository->getFields());
        $primary = $this->repository->getPrimaryField();

        echo '<pre>--QB upd ';
        var_dump($raw, $model);
        unset($raw[$primary->getDb()]);

        var_dump($raw);
        die;
    }

}
