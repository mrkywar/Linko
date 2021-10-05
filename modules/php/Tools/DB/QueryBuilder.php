<?php

namespace Linko\Tools\DB;

use Linko\Models\Core\Model;

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

    public function __construct(DBTable $tableName = null) {
        if (null !== $tableName) {
            $this->tableName = $tableName->getName();
        }

        $this->init();
    }

    private function init() {
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

    /**
     * Allows you to add a field for a query
     * @param DBField $field : Field to add
     * @return $this
     */
    public function addField(DBField $field) {
        $this->fields[] = "`" . $field->getDbName() . "`";
        return $this;
    }

    /**
     * Allows you to add a funtion linked to a field for a query
     * @param string $function : Function string to add
     * @param DBField $fieldAlias : Field used fo alias
     * @return $this
     */
    public function addFunctionField(string $function, DBField $fieldAlias) {
        $this->functionFields[] = $function . "(`" . $fieldAlias->getDbName()
                . "`) as " . $fieldAlias->getDbName();
        return $this;
    }

    /**
     * Allows you to add a function not linked to a field for a query
     * @param string $function : Function string to add
     * @param string $field : Field requested
     * @param string $alias : Alias used 
     * @return $this
     */
    public function addFunctionString(string $function, string $field, string $alias) {
        $this->functionFields[] = $function . "(`" . $field . "`) as " . $alias;
        return $this;
    }

    /**
     * Allows you to add a clause for a query
     * @param DBField $field : Field use for the query clause
     * @param type $value : Value asked (null | array of value | value)
     * @return $this
     */
    public function addClause(DBField $field, $value) {
        $clause = "`" . $field->getDbName() . "`";
        if (is_array($value)) {
            $rawValues = [];
            foreach ($value as $val) {
                $rawValues [] = DBFieldTransposer::transpose($field, $val);
            }
            $clause .= " IN ( " . implode(",", $rawValues) . " )";
        } elseif (null === $value) {
            $clause .= " IS NULL ";
        } else {
            $clause .= " = " .  DBFieldTransposer::transpose($field, $value);
        }

        $this->clauses[] = $clause;

        return $this;
    }

    /**
     * Allows you to add a ordering instruction for a query
     * @param DbField $field : Field use for the query ordering
     * @param string $dir (optionnal, default ASC) : ordering direction 
     * @return $this
     */
    public function addOrderBy(DbField $field, string $dir = QueryString::ORDER_ASC) {
        $this->orderBy[$field->getDbName()] = "`" . $field->getDbName()
                . "` " . $dir;
        return $this;
    }

    /**
     * Allows you to add a set instruction for a query
     * @param DbField $field : Field use for the query set
     * @param type $value : Value of the field
     * @return $this
     */
    public function addSetter(DbField $field, $value) {
        $setter = "`" . $field->getDbName() . "`";
        $setter .= " = " .  DBFieldTransposer::transpose($field, $value);
        $this->setters[$field->getDbName()] = $setter;
        return $this;
    }

    /**
     * Allows you to add a value for a query (use in insert type) 
     * @param Model $model : Model to add
     */
    public function addValue(Model $model) {
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
