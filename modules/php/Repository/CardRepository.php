<?php

namespace Linko\Repository;

use Linko\Repository\Core\SuperRepository;
use Linko\Serializers\CardSerializer;

/**
 * Description of CardRepository
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardRepository extends SuperRepository {
    const TABLE_NAME = "card";
    const FIELDS_PREFIX = "card_";
    const FIELDS = [
        "id" => self::INTEGER_FORMAT,
        "type" => self::STRING_FORMAT,
        "type_arg" => self::STRING_FORMAT,
        "location" => self::STRING_FORMAT,
        "location_arg" => self::STRING_FORMAT
    ];

    public function __construct() {
        $this->serializer = new CardSerializer();
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
