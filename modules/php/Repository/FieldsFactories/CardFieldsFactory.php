<?php

namespace Linko\Repository\FieldsFactories;

use Linko\Repository\Core\Repository;
use Linko\Repository\Core\SuperFieldFactory;
use Linko\Tools\ArrayCollection;

/**
 * Description of PlayerFieldsFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class CardFieldsFactory extends SuperFieldFactory {

    public static function create(Repository $repo) {
        $fields = new ArrayCollection();

        //-- generateField($fieldName,$fieldType,$DBprefix = "",$isUi = false,$isPrimary = false)
        $fields->add(self::generateField("id", Repository::INTEGER_FORMAT, $repo->getFieldsPrefix(), true, true))
                ->add(self::generateField("type", Repository::STRING_FORMAT, $repo->getFieldsPrefix(), true))
                ->add(self::generateField("location", Repository::STRING_FORMAT, $repo->getFieldsPrefix(), true))
        ;

        $locArg = self::generateField("location", Repository::STRING_FORMAT, "", true);
        $locArg->setDb($repo->getFieldsPrefix() . "location_arg");

        $typeArg = self::generateField("type", Repository::STRING_FORMAT, "", true);
        $typeArg->setDb($repo->getFieldsPrefix() . "type_arg");

        $fields->add($locArg)
                ->add($typeArg);

        return $fields;
    }

}

//`card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//  `card_type` varchar(16) NOT NULL,
//  `card_type_arg` int(11) NOT NULL,
//  `card_location` varchar(50) NOT NULL,
//  `card_location_arg` int(11) NOT NULL,