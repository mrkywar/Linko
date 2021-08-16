<?php

namespace Linko\Serializers;

/**
 * Description of Serializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class Serializer {

    const INTEGER_FORMAT = 'int';
    const BOOLEAN_FORMAT = 'bool';
    const STRING_FORMAT = 'string';

    abstract public function serialize(DB_Manager $model);

    abstract public function unserialize(array $row);

    protected function extractFromRow($row, $field, $castType = null) {

        if (!isset($row[$field])) {
            return null;
        }

        switch (strtolower($castType)) {
            case self::INTEGER_FORMAT :
                return (int) $row[$field];
            case self::BOOLEAN_FORMAT :
                return (bool) 1 == $row[$field];
            case self::STRING_FORMAT :
                return (string) $row[$field];
            default : //unsupported casting format
                return $row[$field];
        }

        return null;
    }

}
