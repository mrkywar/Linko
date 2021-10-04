<?php

namespace Linko\Serializers;

use Linko\Serializers\Core\SerializerException;
use Linko\Tools\DB\DBField;
use ReflectionClass;
use ReflectionProperty;

/**
 * Description of Serializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Serializer {

    private const PROPERTY_COLUMN = "@ORM\Column";

    /**
     * 
     * @var string
     */
    private $classModel;

    public function __construct(string $classModel = null) {
        $this->classModel = $classModel;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Serialize & Tools
     * ---------------------------------------------------------------------- */

    public function serialize($items) {
        
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Unserialize & Tools
     * ---------------------------------------------------------------------- */

    public function unserialize($rawItems) {
        if (null === $this->classModel) {
            throw new SerializerException("No class Model defined");
        } elseif (!is_array($rawItems)) {
            throw new SerializerException("Array expected");
        }
        $fields = $this->getDBFields();

        if ($this->isUniqRaw($rawItems, $fields)) {
            return $this->unserializeOnce($rawItems, $fields);
        } else if (is_array($rawItems)) {
            $items = [];
            foreach ($rawItems as $rawItem) {
                $items[] = $this->unserializeOnce($rawItem, $fields);
            }
            return $items;
        }
    }

    private function unserializeOnce($rawItem, $fields) {
        $modelStr = $this->classModel;
        $model = new $modelStr();

        foreach ($fields as $field) {
            if (isset($rawItem[$field->getName()])) {
                $setter = "set" . ucfirst($field->getProperty());
                $model->$setter($rawItem[$field->getName()]);
            }
        }

        return $model;
    }

    private function isUniqRaw($rawItems, $fields) {
        foreach ($fields as $field) {
            if (isset($rawItems[$field->getName()])) {
                return true;
            }
        }
        return false;
    }

    private function getDBFields() {
        $reflexion = new ReflectionClass($this->classModel);
        $fields = [];
        foreach ($reflexion->getProperties() as $property) {
            $obj = $this->getColumDeclaration($property);
            if (null !== $obj) {
                $field = new DBField();
                $field->setName($obj->name)
                        ->setType($obj->type);

                $fields[] = $field;
            }
        }

        return $fields;
    }

    private function getColumDeclaration(ReflectionProperty $property) {
        $strpos = strpos($property->getDocComment(), self::PROPERTY_COLUMN);
        if ($strpos < 0) {
            return;
        }
        $strpos += strlen(self::PROPERTY_COLUMN);

        $chaine = substr($property->getDocComment(), $strpos);
        $jsonStr = substr($chaine, 0, strpos($chaine, "}") + 1);
        return json_decode($jsonStr);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getClassModel(): string {
        return $this->classModel;
    }

    public function setClassModel(string $classModel) {
        $this->classModel = $classModel;
        return $this;
    }

}
