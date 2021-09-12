<?php

namespace Linko\Repository\Core;

use Linko\Models\Core\Field;

/**
 * Factory to create Field List for link Model <--> DB
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperFieldFactory {

    /**
     * Generate a new Field
     * @param type $fieldName : Field name 
     * @param type $fieldType : Field type (int, string,...)
     * @param type $DBprefix : DB prefix (prefix in database)
     * @param type $isUi : True if Field is usfull to display
     * @param type $isPrimary : True if Field is the primary key
     * @return Field
     */
    final protected static function newField(
            $fieldName,
            $fieldType,
            $DBprefix = "",
            $isUi = false,
            $isPrimary = false
    ) {
        $field = new Field();

        $field->setProperty($fieldName)
                ->setDb($DBprefix . $fieldName)
                ->setFieldType($fieldType)
                ->setIsPrimary($isPrimary)
                ->setIsUi($isUi);

        return $field;
    }

    abstract public function create(Repository $repo): array;
}
