<?php

namespace Linko\Repository\Core;

use Linko\Models\Core\Field;

/**
 * Description of SuperFieldFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperFieldFactory {

    final protected static function newField(
            $fieldName,
            $fieldType,
            $DBprefix = "",
            $isUi = false,
            $isPrimary = false
    ) {
        $field = new Field();
        
        $field->setProperty($fieldName)
                ->setDb($DBprefix.$fieldName)
                ->setFieldType($fieldType)
                ->setIsPrimary($isPrimary)
                ->setIsUi($isUi);
        
        return $field;
    }

}