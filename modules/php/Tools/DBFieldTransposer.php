<?php

namespace Linko\Tools;

use Linko\Models\Core\Field;
use Linko\Repository\Core\Repository;


/**
 * Description of FieldTransposer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class DBFieldTransposer {


    public function transpose($value, Field $field) {
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
