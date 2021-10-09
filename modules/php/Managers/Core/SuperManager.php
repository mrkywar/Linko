<?php

namespace Linko\Managers\Core;

use Linko\Serializers\Serializer;
use Linko\Tools\DB\DBRequester;
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
        
//        $qb = new QueryBuilder($tableName);
        
        
        
//        var_dump($fields);die('SM');
//        $tableName = null;
//        $rawItems = $this->getSerializer()->serialize($items);
//        if ($items instanceof Model) {
//            $tableName = DBTableRetriver::retrive(get_class($items));
//            $fields = DBFieldsRetriver::retrive(get_class($items));
//        } elseif (is_array($items)) {
//            $tableName = DBTableRetriver::retrive(get_class($items[0]));
//            $fields = DBFieldsRetriver::retrive(get_class($items[0]));
//        }
//
//        $qb = new QueryBuilder($tableName);
//        $qb->insert()
//                ->setFields($fields)
//                ->setValues($items);
//
//        $this->execute($qb);
    }

}
