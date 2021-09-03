<?php

namespace Linko\Serializers\Core;

use Linko\Models\Core\Field;
use Linko\Models\Core\Model;

/**
 * Description of SuperSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperSerializer implements Serializer {

    /* -------------------------------------------------------------------------
     *                  BEGIN -  Serialize Methods
     * ---------------------------------------------------------------------- */

    /**
     * Object To Array 
     * @param Model $object
     * @return array $rawDatas
     */
    public function serialize(Model $object, array $fields) {
        $raw = [];

        foreach ($fields as $field) {
            $raw[$field->getDb()] = $this->serializeValue($object, $field);
        }

        return $raw;
    }

    private function serializeValue(Model $object, Field $field) {
        $getter = "get" . ucfirst($field->getProperty());
        return $object->$getter();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN -  Unserialize Methods
     * ---------------------------------------------------------------------- */

    abstract public function getModelClass();

    public function unserialize($rawDatas, array $fields) {
        $modelClass = $this->getModelClass();
        $object = new $modelClass();
        
        foreach ($fields as $field) {
            $this->unserializeValue($object, $field, $rawDatas);
        }
        
        return $object;
    }

    private function unserializeValue(Model &$object, Field $field, $rawDatas) {
        $setter = "set" . ucfirst($field->getProperty());
        $object->$setter($rawDatas[$field->getDb()]);
        return $this;
    }


}
