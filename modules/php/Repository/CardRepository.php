<?php

namespace Linko\Repository;

use Linko\Repository\Core\SuperRepository;
use Linko\Repository\FieldsFactories\CardFieldsFactory;
use Linko\Serializers\CardSerializer;
use Linko\Tools\QueryBuilder;


/**
 * Description of PlayerRepository
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardRepository extends SuperRepository {

    const TABLE_NAME = "card";
    const FIELDS_PREFIX = "card_";

    
    public function __construct() {
        $this->serializer = new CardSerializer();
        
        $this->fields = CardFieldsFactory::create($this);
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
    
    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement specific queries
     * ---------------------------------------------------------------------- */
    
    public function getAllInLocation($location , $locationArg = null) {
        $fieldLocation = $this->getFieldsByProperty("location");
        $fieldLocationArg = $this->getFieldsByProperty("locationArg");
        
        $qb = $this->getQueryBuilder()
                ->select()
                ->addWhere($fieldLocation, $location)
                ->addOrderBy($fieldLocationArg, QueryBuilder::ORDER_DESC);
        if(null !== $locationArg){
            $qb->addWhere($fieldLocationArg, $locationArg);
        }
        
        return $qb->execute();
        
    }

}
