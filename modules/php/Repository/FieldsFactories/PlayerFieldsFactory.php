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
abstract class PlayerFieldsFactory extends SuperFieldFactory {

    public static function create(Repository $repo) {
        $fields = new ArrayCollection();

        $fields->add(self::generateField("id", Repository::INTEGER_FORMAT, $repo->getFieldsPrefix(), true, true))
                ->add(self::generateField("name", Repository::STRING_FORMAT, $repo->getFieldsPrefix(), true))
                ->add(self::generateField("canal", Repository::STRING_FORMAT, $repo->getFieldsPrefix()))
                ->add(self::generateField("color", Repository::STRING_FORMAT, $repo->getFieldsPrefix(), true))
                ->add(self::generateField("avatar", Repository::STRING_FORMAT, $repo->getFieldsPrefix(), true))
        ;
        
        return $fields;
    }

}
