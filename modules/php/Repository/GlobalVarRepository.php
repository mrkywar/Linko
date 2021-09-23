<?php

namespace Linko\Repository;

use Linko\Models\GlobalVar;
use Linko\Repository\Core\SuperRepository;

/**
 * GlobaVarlRepository allows you to  manage the GlobalVar (Global Variable) 
 * Model / Data link
 * 
 * Call order :
 * [DBRequester] <--> [QueryBuilder] <--> [Repository] <--> [Manager]
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class GlobalVarRepository extends SuperRepository {

    private CONST TABLE_NAME = "global_var";
    private CONST FIELDS_PREFIX = "global_";

    public function getFieldsPrefix() {
        return self::FIELDS_PREFIX;
    }

    public function getTableName() {
        return self::TABLE_NAME;
    }

    public function update(GlobalVar $globalVar) {
        $valueField = $this->getFieldByProperty("value");
        $primary = $this->getPrimaryField();
        
        $this->setIsDebug(true);

        $qb = $this->getQueryBuilder()
                ->update()           
                ->addSetter($valueField, $globalVar->getValue())
                ->addClause($primary, $globalVar->getId());
 
        $this->execute($qb);
        return $globalVar;
    }

}
