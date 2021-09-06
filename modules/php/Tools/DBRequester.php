<?php

namespace Linko\Tools;

use Linko\Models\Core\Field;
use Linko\Models\Core\QueryString;
use Linko\Tools\Core\DBException;
use Linko\Tools\Core\QueryStatementFactory;

/**
 * Description of DBRequester
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class DBRequester extends \APP_DbObject {

    /**
     * 
     * @var bool
     */
    private $isDebug;

    public function execute(QueryBuilder $qb) {
        $queryString = QueryStatementFactory::create($qb);
//        if ($this->isDebug) {
//            var_dump($queryString);
//            die;
//        }

        switch ($qb->getQueryType()) {
            case QueryString::TYPE_SELECT:
                $results = self::getObjectListFromDB($queryString);
                $res = $this->initKeys($results, $qb->getKeyIndex());
                if ($this->isDebug) {
                    echo "<pre>";
                    var_dump($res,$qb->getKeyIndex());
                    die;
                }
                return $this->initKeys($results, $qb->getKeyIndex());
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

    private function initKeys($results, ?Field $key) {
        if (null === $key) {
            return $results;
        } else {
            $indexed = [];

            for ($i = 0; $i < sizeof($results); $i++) {
                $indexed[$results[$i][$key->getDb()]] = $results[$i];
            }
            return $indexed;
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
