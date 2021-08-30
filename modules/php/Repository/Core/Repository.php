<?php

namespace Linko\Repository\Core;

use Linko\Serializers\Core\Serializer;

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
     *                  BEGIN - Serializer
     * ---------------------------------------------------------------------- */

    /**
     * 
     * @return Serializer
     */
    public function getSerializer(): Serializer;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Fields Management
     * ---------------------------------------------------------------------- */

    public function getTableName();

    public function getFields();

    public function getFieldsPrefix();

    public function getDbFields();

    public function getPrimaryField();
}
