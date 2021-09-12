<?php

namespace Linko\Repository\FieldsFactories;

use Linko\Models\Core\Field;
use Linko\Repository\Core\Repository;
use Linko\Repository\Core\SuperFieldFactory;

/**
 * Description of PlayerFieldsFactory
 * /!\ Alway set the primary field first !!
 * Factory to create Card Fields List for link Model <--> DB
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class CardFieldsFactory extends SuperFieldFactory {

    public static function create(Repository $repo) {
        $fields = [];

        //-- newField($fieldName,$fieldType,$DBprefix = "", $isUi = false,$isPrimary = false)
        $fields[] = self::newField("id", Field::INTEGER_FORMAT, $repo->getFieldsPrefix(), true, true);
        $fields[] = self::newField("type", Field::STRING_FORMAT, $repo->getFieldsPrefix(), true);
        $fields[] = self::newField("location", Field::STRING_FORMAT, $repo->getFieldsPrefix());

        $typeArg = self::newField("type_arg", Field::STRING_FORMAT, $repo->getFieldsPrefix(), true);
        $typeArg->setProperty("typeArg");
        $fields[] = $typeArg;

        $locationArg = self::newField("location_arg", Field::STRING_FORMAT, $repo->getFieldsPrefix());
        $locationArg->setProperty("locationArg");
        $fields[] = $locationArg;

        return $fields;
    }

}
