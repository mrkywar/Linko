<?php

namespace Linko\Repository\FieldsFactories;

use Linko\Models\Core\Field;
use Linko\Repository\Core\Repository;
use Linko\Repository\Core\SuperFieldFactory;

/**
 * Description of StateFieldsFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class StateFieldsFactory extends SuperFieldFactory {

    public static function create(Repository $repo): array {
        $fields = [];
        //-- newField($fieldName,$fieldType,$DBprefix = "", $isUi = false,$isPrimary = false)
        $fields[] = self::newField("id", Field::INTEGER_FORMAT, $repo->getFieldsPrefix(), true, true);
        $fields[] = self::newField("order", Field::INTEGER_FORMAT, $repo->getFieldsPrefix(), true);
        $fields[] = self::newField("state", Field::INTEGER_FORMAT, $repo->getFieldsPrefix(), true);

        $playerField = self::newField("player_id", Field::INTEGER_FORMAT, $repo->getFieldsPrefix(), true);
        $playerField->setProperty("playerId");

        $createdDate = self::newField("created_date", Field::DATETIME_FORMAT, $repo->getFieldsPrefix());
        $createdDate->setProperty("createdDate");

        $playedDate = self::newField("played_date", Field::DATETIME_FORMAT, $repo->getFieldsPrefix());
        $playedDate->setProperty("playedDate");

        $fields[] = $playerField;
        $fields[] = $createdDate;
        $fields[] = $playedDate;

        return $fields;
//        self::newField("type_arg", Field::STRING_FORMAT, $repo->getFieldsPrefix(), true);
    }

}

//`state_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//    `state_state` int(10) UNSIGNED NOT NULL,
//    `state_player_id` int(10) UNSIGNED NULL,
//    `state_created_date` varchar(50) NOT NULL,
//    `state_played_date` varchar(50) NULL,
//    `state_order` int(10) UNSIGNED NOT NULL,