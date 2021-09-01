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
            case Repository::STRING_FORMAT:
                return "'" . addslashes($value) . "'";
            case Repository::BOOLEAN_FORMAT:
                return (true === $value) ? 1 : 0;
            case Repository::INTEGER_FORMAT:
                return "'" . (int) $value . "'";
            default:
                return $value;
        }
    }
    
    
    
}
