<?php

namespace Linko\Repository\FieldsFactories;

use Linko\Models\Core\Field;
use Linko\Repository\Core\Repository;
use Linko\Repository\Core\SuperFieldFactory;

/**
 * Description of LogFieldsFactory
 * /!\ Alway set the primary field first !!
 * Factory to create Log Fields List for link Model <--> DB
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class LogFieldsFactory extends SuperFieldFactory {

    public static function create(Repository $repo): array {
        $fields = [];

        //-- newField($fieldName,$fieldType,$DBprefix = "", $isUi = false,$isPrimary = false)
        $fields[] = self::newField("id", Field::INTEGER_FORMAT, $repo->getFieldsPrefix(), false, true);
        $fields[] = self::newField("date", Field::DATETIME_FORMAT, $repo->getFieldsPrefix(), true);
        $fields[] = self::newField("category", Field::STRING_FORMAT, $repo->getFieldsPrefix(),true);
        $fields[] = self::newField("content", Field::JSON_FORMAT, $repo->getFieldsPrefix(),true);

        return $fields;
    }

}
