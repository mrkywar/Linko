<?php

namespace Linko\Serializers;

use Linko\Serializers\Core\SerializerException;
use Linko\Tools\DB\DBFieldsRetriver;

/**
 * Description of Serializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Serializer {


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
        $fields = DBFieldsRetriver::retrive($this->classModel);

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
                $model->$setter($rawItem[$field->getDbName()]);
            }
        }

        return $model;
    }

    private function isUniqRaw($rawItems, $fields) {
        foreach ($fields as $field) {
            if (isset($rawItems[$field->getDbName()])) {
                return true;
            }
        }
        return false;
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
