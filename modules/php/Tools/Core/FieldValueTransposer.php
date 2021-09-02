<?php
namespace Linko\Tools\Core;

use Linko\Models\Core\Field;

/**
 * Description of FieldValueTransposer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class FieldValueTransposer {
    
    
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
