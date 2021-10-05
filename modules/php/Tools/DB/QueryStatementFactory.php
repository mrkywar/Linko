<?php

namespace Linko\Tools\DB;

/**
 * Description of QueryStatementFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class QueryStatementFactory {

    /**
     * Create the query string to execute from a given QueryBuilder
     * @param QueryBuilder $qb : Query to build
     * @return string : Query ready to execute
     */
    public static function create(QueryBuilder &$qb) {
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

        $qb->reset();

        return $queryString;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - SELECT (private)
     * ---------------------------------------------------------------------- */

    /**
     * Create the complete SELECT query
     * @param QueryBuilder $qb
     * @param type $statement
     */
    private static function createSelectQuery(QueryBuilder $qb, &$statement) {
        $statement .= QueryString::TYPE_SELECT;

        //-- Fields (list or *)
        if (!empty($qb->getFields())) {
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

    /**
     * Create field list (select <FieldList> From ...)
     * @param QueryBuilder $qb
     * @return type
     */
    private static function createFieldList(QueryBuilder $qb) {
        $fieldDb = [];
        foreach ($qb->getFields() as $field) {
            if (Field::BINARY_FORMAT === $field->getFieldType()) {
                $fieldDb[] = " CONVERT (`" . $field->getDb() . "`, CHAR) as "
                        . "`" . $field->getDb() . "`";
            } else {
                $fieldDb[] = " `" . $field->getDb() . "` ";
            }
        }

        return implode(",", $fieldDb);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - UPDATE (private)
     * ---------------------------------------------------------------------- */

    /**
     * Create the complete UPDATE query
     * @param QueryBuilder $qb
     * @param type $statement
     */
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
     *                  BEGIN - SELECT OR UPDATE (private)
     * ---------------------------------------------------------------------- */

    /**
     * Create the query clauses (WHERE ... AND ...)
     * @param QueryBuilder $qb
     * @return type
     */
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
     *                  BEGIN - INSERT  (private)
     * ---------------------------------------------------------------------- */

    /**
     * Create the complete INSERT query
     * @param QueryBuilder $qb
     * @param type $statement
     */
    private static function createInsertQuery(QueryBuilder $qb, &$statement) {
        $statement .= QueryString::TYPE_INSERT . " INTO ";
        $statement .= "`" . $qb->getTableName() . "`";
        
        
        var_dump($qb->getValues());die;
        

//        //-- Fields
//        $statement .= "(" . self::createFieldList($qb) . ")";
//
//        //-- Values 
//        $statement .= " VALUES ";
//        $statement .= implode(",", $qb->getValues());
    }

}
