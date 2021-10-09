<?php

namespace Linko\Managers\Core;

use Linko\Serializers\Serializer;
use Linko\Tools\DB\DBRequester;
use Linko\Tools\DB\DBTableRetriver;
use Linko\Tools\DB\Fields\DBFieldsRetriver;
use Linko\Tools\DB\QueryString;

/**
 * Description of SuperManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperManager extends DBRequester {

    /**
     * @return Serializer
     */
    abstract public function getSerializer();

    protected function create($items) {
        $fields = DBFieldsRetriver::retrive($items, QueryString::TYPE_INSERT);
        $tableName = DBTableRetriver::retrive($items);
        
        $qb = new QueryBuilder($tableName);
        $qb->insert()
                ->setFields($fields)
                ->setValues($items);
        
        $this->execute($qb);
        
    }

}
