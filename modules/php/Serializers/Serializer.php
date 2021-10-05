<?php

namespace Linko\Serializers;

use Linko\Models\Core\Model;
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
        $fields = DBFieldsRetriver::retrive($this->classModel);

        if (is_array($items)) {
            $results = [];
            foreach ($items as $key => $item) {
                $results[] = $this->serializeOnce($item, $fields, $key);
            }
            return $results;
        } else {
            return $this->serializeOnce($items, $fields);
        }
    }

    private function serializeOnce(Model $item, $fields, $key = null) {
        $rawData = [];
        foreach ($fields as $field) {
            $getter = "get" . ucfirst($field->getProperty());
            $rawData[$field->getDbName()] = $item->$getter();
        }
        return $rawData;
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
            foreach ($rawItems as $key => $rawItem) {
                $model = $this->unserializeOnce($rawItem, $fields);
                if (null === $model->getId()) {
                    $model->setId($key);
                }
                $items[] = $model;
            }
            return $items;
        }
    }

    /**
     * Allow you Data To Object transform
     * @param array $rawItem : Raw item to transform
     * @param array<DBField> $fields : Field to use for unserialization
     * @return Model
     */
    private function unserializeOnce($rawItem, $fields) {
        $modelStr = $this->classModel;
        $model = new $modelStr();

        foreach ($fields as $field) {
            if (isset($rawItem[$field->getDbName()])) {
                $setter = "set" . ucfirst($field->getProperty());
                $model->$setter($rawItem[$field->getDbName()]);
            }
        }

        return $model;
    }

    /**
     * Determine if a dataset is an unique raw or not
     * @param array $rawItems : dataset used for test
     * @param array<DBField>  $fields : Field list to check
     * @return boolean true if only one Row false otherwise
     */
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
