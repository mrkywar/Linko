<?php
namespace Linko\Tools\Core;

use Linko\Models\Core\Field;

/**
 * Transpose and prepare fields values for DB queries
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class FieldValueTransposer {
    
    /**
     * Transpose value for query
     * @param Field $field : Field to transpose
     * @param type $value : Value to transpose
     * @return string
     */
    public static function transpose(Field $field, $value) {
        switch ($field->getFieldType()) {
            case Field::STRING_FORMAT:
                return "'" . addslashes($value) . "'";
            case Field::JSON_FORMAT:
                return json_encode($value);
            case Field::BOOLEAN_FORMAT:
                return (true === $value) ? 1 : 0;
            case Field::INTEGER_FORMAT:
                return "'" . (int) $value . "'";
            case Field::DATETIME_FORMAT:
                return "'". self::transposeDateTime($value)."'";
            default:
                return $value;
        }
    }
    
    
    private static function transposeDateTime(\DateTime $datetime) {
        return $datetime->format("Y-m-d H:i:s");
    }
    
    
    
}
//INSERT INTO `log`( `log_id` , `log_date` , `log_category` , `log_content` ) VALUES (null,'2021'
//        . '2021'
//        . '2021'
//        . '2021-0909-1313 2323:4242:1717','debug','END LOGGER !'