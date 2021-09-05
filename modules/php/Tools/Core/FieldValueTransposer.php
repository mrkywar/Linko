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
            case Field::BOOLEAN_FORMAT:
                return (true === $value) ? 1 : 0;
            case Field::INTEGER_FORMAT:
                return "'" . (int) $value . "'";
            default:
                return $value;
        }
    }
    
    
    
}
