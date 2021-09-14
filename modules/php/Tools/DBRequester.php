<?php

namespace Linko\Tools;

use Linko\Managers\Logger;
use Linko\Models\Core\QueryString;
use Linko\Tools\Core\DBException;
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
        $fieldIndex = $qb->getKeyIndex();
        $queryString = QueryStatementFactory::create($qb);
        
        if ($this->isDebug) {
            Logger::getInstance()->log($queryString, "DBRequest");
        }

        switch ($qb->getQueryType()) {
            case QueryString::TYPE_SELECT:
                $results = self::getObjectListFromDB($queryString);

                if (null === $fieldIndex) {
                    return $results;
                } else {
                    return $this->initKeys($results, $fieldIndex->getDb());
                }
                break;

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

    private function initKeys($results, string $indexField) {
        $indexed = [];

        for ($i = 0; $i < sizeof($results); $i++) {
            $indexed[$results[$i][$indexField]] = $results[$i];
        }
        return $indexed;
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
