<?php

namespace Linko\Managers\Core;

use Linko\Models\Core\Model;
use Linko\Serializers\Serializer;
use Linko\Tools\DB\DBFieldsRetriver;
use Linko\Tools\DB\DBTableRetriver;
use Linko\Tools\DB\QueryBuilder;
use Linko\Tools\DB\QueryStatementFactory;

/**
 * Description of SuperManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperManager {

    /**
     * @return Serializer
     */
    abstract public function getSerializer();

    protected function execute(QueryBuilder &$qb) {
        $query = QueryStatementFactory::create($qb);
        var_dump($query);
        die;
    }

//    /**
//     * 
//     * @param Model $model
//     * @param array<Field> $fields
//     */
//    private function getValues(Model $model, array $fields) {
//        $values = [];
//        foreach ($fields as $field) {
//            
//        }
//    }

    protected function create($items) {
        $tableName = null;
//        $rawItems = $this->getSerializer()->serialize($items);
        if ($items instanceof Model) {
            $tableName = DBTableRetriver::retrive(get_class($items));
            $fields = DBFieldsRetriver::retrive(get_class($items));
        } elseif (is_array($items)) {
            $tableName = DBTableRetriver::retrive(get_class($items[0]));
            $fields = DBFieldsRetriver::retrive(get_class($items[0]));
        }

        $qb = new QueryBuilder($tableName);
        $qb->insert()
                ->setFields($fields)
                ->setValues($items);

        $this->execute($qb);
    }

}
