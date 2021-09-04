<?php

namespace Linko\Tools\Core;

use Linko\Models\Core\QueryString;
use Linko\Tools\QueryBuilder;

/**
 * Description of QueryStatementFacrory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class QueryStatementFactory {

    public static function create(QueryBuilder $qb) {
        $queryString = "";
        switch ($qb->getQueryType()) {
            case QueryString::TYPE_SELECT:
                self::createSelectQuery($qb, $queryString);
                break;
            case QueryString::TYPE_INSERT:
                self::createInsertQuery($qb, $queryString);
                break;
            case QueryString::TYPE_UPDATE:
                self::createUpdateQuery($qb, $queryString);
                break;
            case QueryString::TYPE_CUSTOM:
                $queryString = $qb->getStatement();
                break;
        }

        return $queryString;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - SELECT
     * ---------------------------------------------------------------------- */

    private static function createFieldList(QueryBuilder $qb) {
        $fieldDb = [];
        foreach ($qb->getFields() as $field) {
            $fieldDb[] = " `" . $field->getDb() . "` ";
        }

        return " (" . implode(",", $fieldDb) . ") ";
    }

    private static function createSelectQuery(QueryBuilder $qb, &$statement) {
        $statement .= QueryString::TYPE_SELECT;

        //-- Fields (list or *)
        if (null !== $qb->getFields()) {
            $statement .= self::createFieldList($qb);
        } else {
            $statement .= " * ";
        }

        $statement .= " FROM `" . $qb->getTableName() . "` ";

        //-- Clauses
        $statement .= self::generateClauses($qb);

        //-- Order by
        if (sizeof($qb->getOrderBy()) > 0) {
            $statement .= " ORDER BY " . implode(",", $qb->getOrderBy());
        }

        //-- Limit
        if (null !== $qb->getLimit()) {
            $statement .= " LIMIT " . $qb->getLimit();
        }
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - UPDATE
     * ---------------------------------------------------------------------- */

    private static function createUpdateQuery(QueryBuilder $qb, &$statement) {
        $statement .= QueryString::TYPE_UPDATE;
        $statement .= " `" . $qb->getTableName() . "` ";

        //-- Setter
        $statement .= " SET ";
        $statement .= implode(",", $qb->getSetters());

        //-- Clauses
        $statement .= self::generateClauses($qb);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - SELECT OR UPDATE
     * ---------------------------------------------------------------------- */

    private static function generateClauses(QueryBuilder $qb) {
        $statement = "";
        $iteration = 0;
        foreach ($qb->getClauses() as $clause) {
            $statement .= (0 === $iteration) ? " WHERE " : " AND ";
            $statement .= $clause;
            $iteration++;
        }
        return $statement;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - INSERT
     * ---------------------------------------------------------------------- */

    private static function createInsertQuery(QueryBuilder $qb, &$statement) {
        $statement .= QueryString::TYPE_INSERT . " INTO ";
        $statement .= "`" . $qb->getTableName() . "`";

        //-- Fields
        $statement .= self::createFieldList($qb);

        //-- Values 
        $statement .= " VALUES ";
        $statement .= implode(",", $qb->getValues());
    }

}

//private function prepareStatement() {
//        switch ($this->getQueryType()) {
//            case self::TYPE_SELECT:
//                $this->preapareSelect()
//                        ->prepareConditions()
//                        ->prepareOrderBy()
//                        ->prepareLimit();
//                break;
//            case self::TYPE_INSERT:
//                $this->prepareInsert()
//                        ->prepareValues();
//                break;
//            case self::TYPE_UPDATE:
//                $this->perpareUpdate()
//                        ->prepareSetter()
//                        ->prepareConditions();
//                break;
//        }
//        return $this;
//    }