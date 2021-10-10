<?php

namespace Linko\Tools\DB;

use DateTime;
use Linko\Tools\DB\Exceptions\DBValueTransformerException;
use Linko\Tools\DB\Fields\DBField;

/**
 * Description of DBValueTransformer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class DBValueTransformer {

    static public function transform(DBField $field, $value) {
        switch ($field->getType()) {
            case DBField::STRING_FORMAT:
                return "'" . addslashes($value) . "'";
            case DBField::JSON_FORMAT:
                return "'" . json_encode($value) . "'";
            case DBField::BOOLEAN_FORMAT:
                return (true === $value) ? 1 : 0;
            case DBField::INTEGER_FORMAT:
            case DBField::INT_FORMAT:
                return intval($value);
            case DBField::DATETIME_FORMAT:
                return "'" . self::transposeDateTime($value) . "'";
            default:
                var_dump($field, $value, DBField::INTEGER_FORMAT);
                throw new DBValueTransformerException("UNIMPLEMENTED Please contact me with full message log - DBVT-01");
//                return $value;
        }
    }

    static private function transposeDateTime(DateTime $datetime) {
        return $datetime->format("Y-m-d H:i:s");
    }

}
