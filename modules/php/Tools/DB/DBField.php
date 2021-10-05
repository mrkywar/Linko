<?php

namespace Linko\Tools\DB;

/**
 * Description of ColumnProperty
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class DBField {

    /**
     * 
     * @var string
     */
    private $type;

    /**
     * 
     * @var string
     */
    private $dbName;

    /**
     * 
     * @var string
     */
    private $property;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getType(): string {
        return $this->type;
    }

    public function getDbName(): string {
        return $this->dbName;
    }

    
    public function getProperty(): string {
        return $this->property;
    }

    public function setType(string $type) {
        $this->type = $type;
        return $this;
    }

    public function setDbName(string $dbName) {
        $this->dbName = $dbName;
        return $this;
    }

    
    public function setProperty(string $property) {
        $this->property = $property;
        return $this;
    }

}
