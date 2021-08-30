<?php

namespace Linko\Serializers\Core;

use Linko\Models\Core\Field;
use Linko\Models\Model;
use Linko\Tools\ArrayCollection;

/**
 * Description of SuperSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperSerializer implements Serializer {

    protected $isDebug;

    /* -------------------------------------------------------------------------
     *                  BEGIN -  Serialize Methods
     * ---------------------------------------------------------------------- */

    /**
     * Object To Array 
     * @param Model $object
     * @return array $rawDatas
     */
    public function serialize(Model $object, ArrayCollection $fields) {
        $raw = [];

        foreach ($fields as $field) {
            $raw[$field->getDB()] = $this->serializeValue($object, $field);
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

    public function unserialize($rawDatas, ArrayCollection $fields) {
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



    /* -------------------------------------------------------------------------
     *                  BEGIN - debug
     * ---------------------------------------------------------------------- */

    public function setIsDebug(bool $isDebug) {
        $this->isDebug = $isDebug;
        return $this;
    }

}
