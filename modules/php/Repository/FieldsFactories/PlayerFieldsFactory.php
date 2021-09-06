<?php

namespace Linko\Repository\FieldsFactories;

use Linko\Models\Core\Field;
use Linko\Repository\Core\Repository;
use Linko\Repository\Core\SuperFieldFactory;

/**
 * Description of PlayerFieldsFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class PlayerFieldsFactory extends SuperFieldFactory {

    public static function create(Repository $repo) {
        $fields = [];

        //-- newField($fieldName,$fieldType,$DBprefix = "", $isUi = false,$isPrimary = false)
        $fields[] = self::newField("id", Field::INTEGER_FORMAT, $repo->getFieldsPrefix(), true, true);
        $fields[] = self::newField("name", Field::STRING_FORMAT, $repo->getFieldsPrefix(), true);
        $fields[] = self::newField("canal", Field::STRING_FORMAT, $repo->getFieldsPrefix());
        $fields[] = self::newField("color", Field::STRING_FORMAT, $repo->getFieldsPrefix(), true);
        $fields[] = self::newField("avatar", Field::STRING_FORMAT, $repo->getFieldsPrefix(), true);
        $fields[] = self::newField("beginer", Field::BINARY_FORMAT, $repo->getFieldsPrefix(), true);
        $fields[] = self::newField("score", Field::INTEGER_FORMAT, $repo->getFieldsPrefix(), true);
        $fields[] = self::newField("zombie", Field::BOOLEAN_FORMAT, $repo->getFieldsPrefix(), true);
        
        $isAi = self::newField("ai", Field::BOOLEAN_FORMAT, $repo->getFieldsPrefix(), true);
        $isAi->setProperty("isAi");
        
        $fields[] = $isAi;

        return $fields;
        
        
        
//            private $beginner;
//    private $isAi;
//    private $score;
//    private $zombie;
//    private $eliminated;
//
////color_back: null
////eliminated: 0
////is_ai: "0"
////score: "0"
////zombie: 0
    }

}
