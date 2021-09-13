<?php

namespace Linko\Repository\Core;

use Linko\Models\Core\Field;
use Linko\Serializers\Core\Serializer;
use Linko\Tools\Core\UIAdapter;
use Linko\Tools\DBRequester;
use Linko\Tools\QueryBuilder;

/**
 * SuperRepository allows you to globally manage the model / Data link
 * Call order :
 * [DBRequester] <--> [QueryBuilder] <--> [Repository] <--> [Manager]
 * @todo SHOW if some more methods can have final declaration
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperRepository implements Repository {

    /**
     * @var DBRequester
     */
    protected $dbRequester;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var array 
     */
    protected $fields;

    /**
     * @var bool
     */
    private $isDebug;

    /**
     * @var bool
     */
    protected $doUnserialization = false;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    /**
     * Get DBRequester for execute a query 
     * @return DBRequester
     */
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
     * @param Serializer $serializer
     * @return $this
     */
    public function setSerializer(Serializer $serializer): Repository {
        $this->serializer = $serializer;
        return $this;
    }

    /**
     * 
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder {
        $qb = new QueryBuilder();
        $qb->setTableName($this->getTableName());
        return $qb;
    }

    /**
     * get the unserialization requirement
     * @return bool
     */
    public function getDoUnserialization(): bool {
        return $this->doUnserialization;
    }

    /**
     * set the unserialization requirement
     * @return bool
     */
    public function setDoUnserialization(bool $doUnserialization): Repository {
        $this->doUnserialization = $doUnserialization;
        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Fields Management
     * ---------------------------------------------------------------------- */

    abstract public function getTableName();

    abstract public function getFieldsPrefix();

    /**
     * Get list of fields (array<Field>)
     * @return array
     */
    final public function getFields(): array {
        return $this->fields;
    }

    /**
     * set list of fields (array<Field>)
     * @return array
     */
    final public function setFields(array $fields) {
        $this->fields = $fields;
    }

    /**
     * Retrive the primary Field
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
     * @todo Check if it's usefull
     * @return array all DBFields (array<string>)
     */
    public function getDbFields(): array {
        $res = [];
        $fields = $this->getFields();
        foreach ($fields as $field) {
            $res [] = $field->getDb();
        }
        return $res;
    }

    /**
     * get all UIFields (usfull for display)
     * @return array all DBFields (array<Field>)
     */
    public function getUIFields(): array {
        $res = [];
        $fields = $this->getFields();
        foreach ($fields as $field) {
            if ($field->isUi()) {
                $res [] = $field;
            }
        }
        return $res;
    }

    /**
     * Retrive a field by this property
     * @param string $property
     * @return Field
     */
    public function getFieldByProperty($property) {
        foreach ($this->getFields() as $field) {
            if (ucfirst($property) === $field->getProperty()) {
                return $field;
            }
        }
        return;
    }

    /**
     * Retrive a field by this dbfield
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

    /**
     * execute a queryBuilder
     * @param QueryBuilder $qb QueryBuilder to execute
     * @param type $doUnserialize indicates if the result must be in the form 
     * of an object array or not (optional) by default true
     * @return type
     */
    final protected function execute(QueryBuilder $qb) {
        $queryResults = $this->getDbRequester()->execute($qb);
        if($this->isDebug){
            var_dump($queryResults,$qb);die("SR");
        }
        if (!is_array($queryResults)) {
            return $queryResults;
        }

        if (0 === sizeof($queryResults)) {
            return null;
        } elseif ($this->doUnserialization) {
            return $this->getSerializer()
                            ->unserialize($queryResults, $this->getFields());
        } else {
            return UIAdapter::adapt($this, $queryResults);
        }
    }

    /**
     * Retrive all items in DB (return a array of rawDatas)
     * @return array
     */
    public function getAll() {
        $qb = $this->getQueryBuilder()->select();

        return $this->execute($qb);
    }

    /**
     * Retrive items in DB by Id (return a array of rawDatas)
     * Usable with array of ids
     * @param type $id (can be an unique Id or array of Id)
     * @return type
     */
    public function getById($id) {
        $qb = $this->getQueryBuilder()
                ->select()
                ->addClause($this->getPrimaryField(), $id);

        return $this->execute($qb);
    }

    /**
     * Create items (insert) in DB
     * @param type $items
     * @return type
     */
    public function create($items) {
        $qb = $this->getQueryBuilder()
                ->insert()
                ->setFields($this->getFields());

        $primary = $this->getPrimaryField();

        if (is_array($items)) {
            foreach ($items as $item) {
                $qb->addValue($item, $primary);
            }
        } else {
            $qb->addValue($items, $primary);
        }

        return $this->execute($qb);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Debug
     * ---------------------------------------------------------------------- */

    /**
     * Get debug status (true if enable)
     * @return bool
     */
    final public function getIsDebug(): bool {
        return $this->isDebug;
    }

    /**
     * Set debug status (true to enable). Alway chain set the debug status 
     * to Requester
     * @param bool $isDebug
     * @return Repository
     */
    final public function setIsDebug(bool $isDebug): Repository {
        $this->isDebug = $isDebug;
        $this->getDbRequester()->setIsDebug($isDebug);

        return $this;
    }

}
