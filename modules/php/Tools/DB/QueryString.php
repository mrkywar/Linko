<?php

namespace Linko\Tools\DB;

/**
 * Description of QueryString
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class QueryString {

    const TYPE_SELECT = "SELECT";
    const TYPE_INSERT = "INSERT";
    const TYPE_UPDATE = "UPDATE";
    const TYPE_CUSTOM = "CUSTOM";
    const ORDER_ASC = "ASC";
    const ORDER_DESC = "DESC";

    public function stringifyValue(DBField $field, $value) {
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
