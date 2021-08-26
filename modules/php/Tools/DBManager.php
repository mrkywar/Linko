<?php

namespace Linko\Tools;

/**
 * Description of Tools
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class DBManager extends \APP_DbObject {
   
    
    public function getQueryBuilder($table = null) {
        if (is_null($table)) {
            if (is_null($this->getTableName())) {
                throw new \feException('You must specify the table you want to do the query on');
            }
            $table = $this->getTableName();
        }

        return new QueryBuilder(
                $table,
                function ($row) {
                    return $this->cast($row);
                },
                $this->getPrimary()
        );
    }
    
}
