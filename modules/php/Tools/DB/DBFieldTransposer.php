<?php

namespace Linko\Tools\DB;

/**
 * Description of DBFieldTransposer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class DBFieldTransposer {

    static public function transpose(DBField $field, $value) {
        if (null === $value) {
            return "null";
        }
        switch ($field->getFieldType()) {
            case Field::STRING_FORMAT:
                return "'" . addslashes($value) . "'";
            case Field::JSON_FORMAT:
                return "'" . json_encode($value) . "'";
            case Field::BOOLEAN_FORMAT:
                return (true === $value) ? 1 : 0;
            case Field::INTEGER_FORMAT:
                return "'" . (int) $value . "'";
            case Field::DATETIME_FORMAT:
                return "'" . $value->format("Y-m-d H:i:s") . "'";
            default:
                return $value;
        }
    }

}
