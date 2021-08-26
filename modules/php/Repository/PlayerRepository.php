<?php

namespace Linko\Repository;

use Linko\Repository\Core\SuperRepository;
use Linko\Serializers\Core\Serializer;
use Linko\Serializers\PlayerSerializer;

/**
 * Description of PlayerRepository
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerRepository extends SuperRepository {

    const TABLE_NAME = "player";
    const FIELDS_PREFIX = "player_";
    const FIELDS = [
        "id" => self::INTEGER_FORMAT,
        //"no" => self::INTEGER_FORMAT,
        "name" => self::STRING_FORMAT,
        "canal" => self::STRING_FORMAT,
        "color" => self::STRING_FORMAT,
        "avatar" => self::STRING_FORMAT
    ];

    public function __construct() {
        $this->serializer = new PlayerSerializer();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement Repository Management
     * ---------------------------------------------------------------------- */

    public function getTableName() {
        return self::TABLE_NAME;
    }

    public function getFieldsPrefix() {
        return self::FIELDS_PREFIX;
    }

    public function getFields() {
        return array_keys(self::FIELDS);
    }

    public function getFieldType($fieldName) {
        if (isset(self::FIELDS[$fieldName])) {
            return self::FIELDS[$fieldName];
        } else {
            return null;
        }
    }

}
