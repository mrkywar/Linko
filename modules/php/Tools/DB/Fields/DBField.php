<?php

namespace Linko\Tools\DB\Fields;

/**
 * Description of ColumnProperty
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class DBField {

    const STRING_FORMAT = "string";
    const INTEGER_FORMAT = "integer";
    const INT_FORMAT = "int";
    const BOOLEAN_FORMAT = "boolean";
    const BINARY_FORMAT = "binary";
    const DATETIME_FORMAT = "datetime";
    const JSON_FORMAT = "json";

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

    /**
     * @var bool
     */
    private $isPrimary = false;

    /**
     * 
     * @var array|null
     */
    private $exclusions;

    /**
     * 
     * @var string|null
     */
    private $default;

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

    public function getIsPrimary(): bool {
        return $this->isPrimary;
    }

    public function getExclusions(): ?array {
        return $this->exclusions;
    }

    public function getDefault(): ?string {
        return $this->default;
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

    public function setIsPrimary(bool $isPrimary) {
        $this->isPrimary = $isPrimary;
        return $this;
    }

    public function setExclusions(?array $exclusions) {
        $this->exclusions = $exclusions;
        return $this;
    }

    public function setDefault(?string $default) {
        $this->default = $default;
        return $this;
    }

}
