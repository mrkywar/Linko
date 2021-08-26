<?php

namespace Linko\Repository;

use Linko\Serializers\CardSerializer;
use Linko\Serializers\Serializer;

/**
 * Description of CardRepository
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardRepository implements Repository{
    const TABLE_NAME = "card";
    const FIELDS_PREFIX = "card_";
    const FIELDS = [
        "id" => self::INTEGER_FORMAT,
        //"no" => self::INTEGER_FORMAT,
        "type" => self::STRING_FORMAT,
        "type_arg" => self::STRING_FORMAT,
        "location" => self::STRING_FORMAT,
        "location_arg" => self::STRING_FORMAT
    ];

    private $queryBuilder;
    private $serializer;
    
    
    
    public function __construct() {
        $this->queryBuilder = new QueryBuilder($this);
        $this->serializer = new CardSerializer();
    }
    
    public function create($items) {
        
    }

    public function getAll() {
        
    }

    public function getDbFields() {
        
    }

    public function getFieldType($fieldName) {
        
    }

    public function getFields() {
        
    }

    public function getFieldsPrefix() {
        
    }

    public function getSerializer(): Serializer {
        
    }

    public function getTableName() {
        
    }

}


//CREATE TABLE IF NOT EXISTS `card` (
//  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//  `card_type` varchar(16) NOT NULL,
//  `card_type_arg` int(11) NOT NULL,
//  `card_location` varchar(50) NOT NULL,
//  `card_location_arg` int(11) NOT NULL,
//  PRIMARY KEY (`card_id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;