<?php

namespace Linko\Repository;

use Linko\Repository\Core\SuperRepository;
use Linko\Repository\FieldsFactories\PlayerFieldsFactory;
use Linko\Serializers\PlayerSerializer;

/**
 * Description of PlayerRepository
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerRepository extends SuperRepository {

    const TABLE_NAME = "player";
    const FIELDS_PREFIX = "player_";
    
    public function __construct() {
        $this->serializer = new PlayerSerializer();
        
        $this->fields = PlayerFieldsFactory::create($this);
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

}
