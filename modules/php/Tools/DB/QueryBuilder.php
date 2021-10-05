<?php

namespace Linko\Tools\DB;

/**
 * Description of QueryBuilder
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class QueryBuilder {

    /**
     * @var string|null
     */
    private $queryType;

    /**
     * @var string|null
     */
    private $tableName;

    /**
     * @var string|null
     */
    private $statement;

    /**
     * @var QueryString
     */
    private $transformer;

    /**
     * to setup a keyIndex
     * @var Field|null
     */
//    private $keyIndex;

    /* -------------------------------------------------------------------------
     *                  Properties - Select
     * ---------------------------------------------------------------------- */

    /**
     * @var array
     */
    private $fields = [];

    /**
     * @var array
     */
    private $functionFields = [];

    /**
     * @var array
     */
    private $clauses = [];

    /**
     * @var array
     */
    private $orderBy = [];

    /**
     * @var int|null
     */
    private $limit;

    /* -------------------------------------------------------------------------
     *                  Properties - Update
     * ---------------------------------------------------------------------- */

    /**
     * @var array
     */
    private $setters = [];

    /* -------------------------------------------------------------------------
     *                  Properties - Create
     * ---------------------------------------------------------------------- */

    /**
     * 
     * @var array
     */
    private $values = [];

    /* -------------------------------------------------------------------------
     *                  BEGIN - construct
     * ---------------------------------------------------------------------- */

    public function __construct($tableName = null) {
        if (null !== $tableName) {
            $this->tableName = $tableName;
        }
        $this->transformer = new QueryString();
        $this->init();
    }

    private function init() {
        $this->statement = "";
        $this->keyIndex = null;
        //-- (re)init select
        $this->orderBy = [];
        $this->limit = null;
        $this->clauses = [];
        $this->fields = [];
        $this->functionFields = [];

        //-- (re)init update
        $this->setters = [];

        //-- (re)init insert
        $this->setters = [];
        return $this;
    }

    public function reset() {
        return $this->init();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Query Type 
     * ---------------------------------------------------------------------- */

    public function select() {
        $this->queryType = QueryString::TYPE_SELECT;
        return $this;
    }

    public function insert() {
        $this->queryType = QueryString::TYPE_INSERT;
        return $this;
    }

    public function update() {
        $this->queryType = QueryString::TYPE_UPDATE;
        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Adders
     * ---------------------------------------------------------------------- */

    public function addField(DBField $field) {
        $this->fields[] = "`" . $field->getDbName() . "`";
        return $this;
    }

    public function addFunctionField(string $function, DBField $fieldAlias = null) {
        $this->functionFields[] = $function . "(`" . $fieldAlias->getDbName()
                . "`) as " . $fieldAlias->getDbName();
        return $this;
    }

    public function addFunctionString(string $function, string $field, string $alias) {
        $this->functionFields[] = $function . "(`" . $field . "`) as " . $alias;
        return $this;
    }

    public function addClause(DBField $field, $value) {
        $clause = "`" . $field->getDbName() . "`";
        if (is_array($value)) {
            $rawValues = [];
            foreach ($value as $val) {
                $rawValues [] = $this->transformer->stringifyValue($field, $val);
            }
            $clause .= " IN ( " . implode(",", $rawValues) . " )";
        } elseif (null === $value) {
            $clause .= " IS NULL ";
        } else {
            $clause .= " = " . $this->transformer->stringifyValue($field, $value);
        }

        $this->clauses[] = $clause;

        return $this;
    }

    public function addOrderBy(DbField $field, $dir = QueryString::ORDER_ASC) {
        $this->orderBy[$field->getDbName()] = "`" . $field->getDbName()
                . "` " . $dir;
        return $this;
    }

    public function addSetter(DbField $field, $value) {
        $setter = "`" . $field->getDbName() . "`";
        $setter .= " = " . $this->transformer->stringifyValue($field, $value);
        $this->setters[$field->getDbName()] = $setter;
        return $this;
    }
    
    public function addValue(Model $model){
        $this->values[] = $model;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters
     * ---------------------------------------------------------------------- */

    public function getQueryType(): ?string {
        return $this->queryType;
    }

    public function getTableName(): ?string {
        return $this->tableName;
    }

    public function getStatement(): ?string {
        return $this->statement;
    }

    public function getFields(): array {
        return $this->fields;
    }

    public function getFunctionFields(): array {
        return $this->functionFields;
    }

    public function getClauses(): array {
        return $this->clauses;
    }

    public function getOrderBy(): array {
        return $this->orderBy;
    }

    public function getLimit(): ?int {
        return $this->limit;
    }

    public function getSetters(): array {
        return $this->setters;
    }

    public function getValues(): array {
        return $this->values;
    }

    public function setQueryType(?string $queryType) {
        $this->queryType = $queryType;
        return $this;
    }

    public function setTableName(?string $tableName) {
        $this->tableName = $tableName;
        return $this;
    }

    public function setStatement(?string $statement) {
        $this->statement = $statement;
        return $this;
    }

    public function setFields(array $fields) {
        $this->fields = $fields;
        return $this;
    }

    public function setFunctionFields(array $functionFields) {
        $this->functionFields = $functionFields;
        return $this;
    }

    public function setClauses(array $clauses) {
        $this->clauses = $clauses;
        return $this;
    }

    public function setOrderBy(array $orderBy) {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setLimit(?int $limit) {
        $this->limit = $limit;
        return $this;
    }

    public function setSetters(array $setters) {
        $this->setters = $setters;
        return $this;
    }

    public function setValues(array $values) {
        $this->values = $values;
        return $this;
    }

}
