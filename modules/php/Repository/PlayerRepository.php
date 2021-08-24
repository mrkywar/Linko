<?php

namespace Linko\Repository;

use Linko\Serializers\PlayerSerializer;
use Linko\Serializers\Serializer;
use Linko\Tools\QueryBuilder;

/**
 * Description of PlayerRepository
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerRepository implements Repository {

    const TABLE_NAME = "player";
    const FIELDS_PREFIX = "player_";
    const FIELDS = [
        "id" => self::INTEGER_FORMAT,
        "no" => self::INTEGER_FORMAT,
        "name" => self::STRING_FORMAT,
        "canal" => self::STRING_FORMAT,
        "color" => self::STRING_FORMAT,
        "avatar" => self::STRING_FORMAT
    ];

    private $queryBuilder;
    private $serializer;

    public function __construct() {
        $this->queryBuilder = new QueryBuilder($this);

        $this->serializer = new PlayerSerializer();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement Repository Management
     * ---------------------------------------------------------------------- */

    public function getSerializer(): Serializer {
        return $this->serializer;
    }

    public function getTableName() {
        return self::TABLE_NAME;
    }

    public function getFieldsPrefix() {
        return self::FIELDS_PREFIX;
    }

    public function getFields() {
        return array_keys(self::FIELDS);
    }

    public function getDbFields() {
        $res = [];
        foreach ($this->getFields() as $fieldName) {
            if (isset(self::FIELDS[$fieldName])) {
                $res [] = self::FIELDS_PREFIX . $fieldName;
            }
        }
        return $res;
    }

    public function getFieldType($fieldName) {

        if (isset(self::FIELDS[$fieldName])) {
            return self::FIELDS[$fieldName];
        } else {
            return null;
        }
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement Base queries
     * ---------------------------------------------------------------------- */

    public function getAll() {
        return $this->queryBuilder->getAll();
    }

    public function create($items) {
        return $this->queryBuilder->create($items);
    }

}
