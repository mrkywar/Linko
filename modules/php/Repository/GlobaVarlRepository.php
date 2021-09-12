<?php

namespace Linko\Repository;

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
class GlobaVarlRepository extends SuperRepository{
    private CONST TABLE_NAME = "global_var";
    private CONST FIELDS_PREFIX = "global_";
    
    public function getFieldsPrefix() {
        return self::FIELDS_PREFIX;
    }

    public function getTableName() {
        return self::TABLE_NAME;
    }

}
