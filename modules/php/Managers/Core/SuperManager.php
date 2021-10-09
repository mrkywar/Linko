<?php

namespace Linko\Managers\Core;

use Linko\Serializers\Serializer;
use Linko\Tools\DB\DBRequester;
use Linko\Tools\DB\DBTableRetriver;
use Linko\Tools\DB\Fields\DBFieldsRetriver;
use Linko\Tools\DB\Fields\DBFiledsFilter;
use Linko\Tools\DB\QueryBuilder;
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
    
    final protected function getInsertFields($items){
        $fields = DBFieldsRetriver::retrive($items);
        $filtered = DBFiledsFilter::filter($fields, QueryString::TYPE_INSERT);
        return $filtered;
    }

    protected function create($items) {
        $fields = $this->getInsertFields($items);
        $table = DBTableRetriver::retrive($items);
        
        $qb = new QueryBuilder();
        $qb->setTable($table)
                ->insert()
                ->setFields($fields)
                ->setValues($items);
        
        $this->execute($qb);
        
    }

}
