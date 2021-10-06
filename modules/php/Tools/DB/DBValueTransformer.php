<?php

namespace Linko\Tools\DB;

/**
 * Description of DBValueTransformer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class DBValueTransformer {

    static public function transform(DBField $field, $value) {
        if (null === $value) {
            return "null";
        }
        var_dump($field->getDbName(), $field->getType());
        switch ($field->getType()) {
            case DBField::STRING_FORMAT:
                return "'" . addslashes($value) . "'";
            case DBField::JSON_FORMAT:
                return "'" . json_encode($value) . "'";
            case DBField::BOOLEAN_FORMAT:
                return (true === $value) ? 1 : 0;
            case DBField::INTEGER_FORMAT:
                return intval($value);
            case DBField::DATETIME_FORMAT:
                return "'" . self::transposeDateTime($value) . "'";
//            default:
//                return $value;
        }
    }

}
