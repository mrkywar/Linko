<?php

namespace Linko\Tools;

abstract class DB_Manager extends \APP_DbObject {

    abstract protected function getTableName();

    abstract protected function getPrimary();

    protected function cast($row) {
        return $row;
    }

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

//    public function DB($table = null) {
//        if (is_null($table) {
//            if (null === ) {
//                throw new \feException('You must specify the table you want to do the query on');
//            }
//            //$table = self::getTableName();
//        }
//
////        return new QueryBuilder(
////                $table,
////                function ($row) {
////                    return static::cast($row);
////                },
////                static::$primary
////        );
//    }
}
