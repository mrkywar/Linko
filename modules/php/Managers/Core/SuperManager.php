<?php

namespace Linko\Managers\Core;

use Linko\Models\Core\Model;
use Linko\Serializers\Core\SerializerException;
use Linko\Tools\DB\DBTableRetriver;
use Linko\Tools\DB\QueryBuilder;
use Linko\Tools\DB\QueryStatementFactory;

/**
 * Description of SuperManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class SuperManager {

    abstract public function getSerializer();

    protected function execute(QueryBuilder &$qb) {
        $query = QueryStatementFactory::create($qb);
        var_dump($query);
        die;
    }

    protected function create($items) {
        $tableName = null;
        if ($items instanceof Model) {
            $tableName = DBTableRetriver::retrive(get_class($items));
        } elseif (is_array($items)) {
            $tableName = DBTableRetriver::retrive(get_class($items[0]));
        }

        if (null === $tableName) {
            throw new SerializerException("Invalid items param");
        }

        $qb = new QueryBuilder($tableName);
        $qb->insert()
                ->setValues($items);

        $this->execute($qb);
    }

}
