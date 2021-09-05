<?php

namespace Linko\Tools;

use Linko\Models\Core\QueryString;
use Linko\Tools\Core\QueryStatementFactory;

/**
 * DataBase Requester allow send requests to database
 *
 * [DBRequester] <--> [QueryBuilder] <--> [Repository] <--> [Manager]
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class DBRequester extends \APP_DbObject {
    
    /**
     * 
     * @var bool
     */
    private $isDebug;
      
    /**
     * Execute the given QueryBuilder
     * @param QueryBuilder $qb
     * @return type
     * @throws DBException
     */
    public function execute(QueryBuilder $qb) {
        $queryString = QueryStatementFactory::create($qb);
        if($this->isDebug){
            var_dump($queryString);die;
        }

        switch ($qb->getQueryType()) {
            case QueryString::TYPE_SELECT:
                return self::getObjectListFromDB($queryString);
            case QueryString::TYPE_INSERT:
                self::DbQuery($queryString);
                return self::DbGetLastId();
            case QueryString::TYPE_UPDATE:
                self::DbQuery($queryString);
                return self::DbAffectedRow();
            default :
                throw new DBException("DBR : Execute : Not Implemented Yet");
        }
    }
    

    /* -------------------------------------------------------------------------
     *                  BEGIN - Debug
     * ---------------------------------------------------------------------- */
    
    public function getIsDebug(): bool {
        return $this->isDebug;
    }

    public function setIsDebug(bool $isDebug) {
        $this->isDebug = $isDebug;
        return $this;
    }



}