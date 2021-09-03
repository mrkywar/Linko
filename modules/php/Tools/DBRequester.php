<?php

namespace Linko\Tools;

use Linko\Models\Core\QueryString;
use Linko\Tools\Core\QueryStatementFactory;

/**
 * Description of DBRequester
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class DBRequester extends \APP_DbObject {

    public function execute(QueryBuilder $qb) {
        $queryString = QueryStatementFactory::create($qb);

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

}