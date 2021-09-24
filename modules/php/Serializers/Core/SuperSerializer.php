<?php

namespace Linko\Serializers\Core;

use Linko\Models\Core\Field;
use Linko\Models\Core\Model;

/**
 * SuperSerializer allows you to globally serialize or unserialize
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperSerializer implements Serializer {
    /* -------------------------------------------------------------------------
     *                  BEGIN -  Serialize Methods
     * ---------------------------------------------------------------------- */

    /**
     * Transform Object To Array 
     * @param Model $object
     * @return array $rawDatas
     */
    public function serialize(Model $object, array $fields) {
        $raw = [];

        foreach ($fields as $field) {
//            if (isset($raw[$field->getDb()])) {
                $raw[$field->getDb()] = $this->serializeValue($object, $field);
//            }
        }

        return $raw;
    }

    private function serializeValue(Model $object, Field $field) {
        $getter = "get" . $field->getProperty();
        return $object->$getter();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN -  Unserialize Methods
     * ---------------------------------------------------------------------- */

    /**
     * give the class of associated model
     * @return type
     */
    abstract public function getModelClass();

    /**
     * Transform Array to Object (only one raw in input)
     * @param Model $object
     * @param mixed $key key of array
     * @return array $rawDatas
     */
    private function unserializeOnce($rawDatas, $key, array $fields) {
        $modelClass = $this->getModelClass();
        $object = new $modelClass();
        $primary = null;

        foreach ($fields as $field) {
            $this->unserializeValue($object, $field, $rawDatas);
            if ($field->isPrimary()) {
                $primary = $field;
            }
        }
        if (null !== $primary && !isset($rawDatas[$primary->getDb()])) {
            $rawDatas[$primary->getDb()] = $key;
            $this->unserializeValue($object, $primary, $rawDatas);
        }


        return $object;
    }

    /**
     * Transform Array to Object 
     * @param Model $object
     * @return array $rawDatas
     */
    public function unserialize($rawDatas, array $fields) {
        if (1 === sizeof($rawDatas)) {
            $key = array_keys($rawDatas)[0];
            return $this->unserializeOnce($rawDatas[$key], $key, $fields);
        }
        $objects = [];
        foreach ($rawDatas as $key => $raw) {
            $objects[] = $this->unserializeOnce($raw, $key, $fields);
        }
        return $objects;
    }

    private function unserializeValue(Model &$object, Field $field, $rawDatas) {
        $setter = "set" . ucfirst($field->getProperty());
        if (isset($rawDatas[$field->getDb()])) {
            $object->$setter($rawDatas[$field->getDb()]);
        }
        return $this;
    }

}
