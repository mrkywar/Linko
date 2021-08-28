<?php

namespace Linko\Models\Core;

/**
 * Description of Fields
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Field {

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

    public function getProperty(): string {
        return $this->property;
    }

    public function getDb(): string {
        return $this->db;
    }

    public function getIsUi(): bool {
        return $this->isUi;
    }

    public function getFieldType(): string {
        return $this->fieldType;
    }

    public function getIsPrimary(): bool {
        return $this->isPrimary;
    }

    public function setProperty(string $property) {
        $this->property = $property;
        return $this;
    }

    public function setDb(string $db) {
        $this->db = $db;
        return $this;
    }

    public function setIsUi(bool $isUi) {
        $this->isUi = $isUi;
        return $this;
    }

    public function setFieldType(string $fieldType) {
        $this->fieldType = $fieldType;
        return $this;
    }

    public function setIsPrimary(bool $isPrimary) {
        $this->isPrimary = $isPrimary;
        return $this;
    }

    public function isUi(): bool {
        return $this->getIsUi();
    }

    public function isPriamry(): bool {
        return $this->getIsPrimary();
    }

}
