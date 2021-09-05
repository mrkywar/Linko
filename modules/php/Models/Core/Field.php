<?php

namespace Linko\Models\Core;

/**
 * Field is the link between Model and DB
 * Model<Property> <--> Data<Db>
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Field {

    const STRING_FORMAT = "string";
    const INTEGER_FORMAT = "int";
    const BOOLEAN_FORMAT = "boolean";

    /**
     * @var string
     */
    private $property;

    /**
     * @var string
     */
    private $db;

    /**
     * @var string
     */
    private $fieldType;

    /**
     * @var bool
     */
    private $isUi;

    /**
     * @var bool
     */
    private $isPrimary;

    public function __construct() {
        $this->isPrimary = false;
        $this->isUi = false;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    /**
     * To get property name in associated Model
     * @return string
     */
    public function getProperty(): string {
        return $this->property;
    }

    /**
     * To get db field in associated DBTable (Repository)
     * @return string
     */
    public function getDb(): string {
        return $this->db;
    }

    /**
     * To get isUi boolean, true if field is usefull for display
     * @return bool
     */
    public function getIsUi(): bool {
        return $this->isUi;
    }

    /**
     * to get the field type (int, string,...)
     * @return string
     */
    public function getFieldType(): string {
        return $this->fieldType;
    }

    /**
     * to get is a primary field (true if primary)
     * @return bool
     */
    public function getIsPrimary(): bool {
        return $this->isPrimary;
    }

    /**
     * To set property name in associated Model
     * @param string $property
     * @return $this
     */
    public function setProperty(string $property) {
        $this->property = ucfirst($property);
        return $this;
    }

    /**
     * To set db field in associated DBTable (Repository)
     * @param string $db
     * @return $this
     */
    public function setDb(string $db) {
        $this->db = $db;
        return $this;
    }

    /**
     * To set isUi boolean, true if field is usefull for display
     * @param bool $isUi
     * @return $this
     */
    public function setIsUi(bool $isUi) {
        $this->isUi = $isUi;
        return $this;
    }

    /**
     * to set the field type (int, string,...)
     * @param string $fieldType
     * @return $this
     */
    public function setFieldType(string $fieldType) {
        $this->fieldType = $fieldType;
        return $this;
    }

    /**
     * to set is a primary field (true if primary)
     * @param bool $isPrimary
     * @return $this
     */
    public function setIsPrimary(bool $isPrimary) {
        $this->isPrimary = $isPrimary;
        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Only shortcut (not usefull code)
     * ---------------------------------------------------------------------- */

    /**
     * To get isUi boolean, true if field is usefull for display
     * @return bool
     */
    public function isUi(): bool {
        return $this->getIsUi();
    }

    /**
     * to get is a primary field (true if primary)
     * @return bool
     */
    public function isPrimary(): bool {
        return $this->getIsPrimary();
    }

}
