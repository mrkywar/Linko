<?php

namespace Linko\Repository\Core;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
interface Repository {

    const STRING_FORMAT = "string";
    const INTEGER_FORMAT = "int";
    const BOOLEAN_FORMAT = "boolean";

    /* -------------------------------------------------------------------------
     *                  BEGIN - Base queries
     * ---------------------------------------------------------------------- */

    public function getAll();

    public function create($items);

    /* -------------------------------------------------------------------------
     *                  BEGIN - Fields Management
     * ---------------------------------------------------------------------- */

    public function getTableName();

    public function getFields();

    public function getFieldsPrefix();

    public function getDbFields();
    
    public function getPrimaryField();
}
