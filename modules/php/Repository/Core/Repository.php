<?php

namespace Linko\Repository\Core;

use Linko\Models\Core\Field;
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

    public function getById($id);

    public function update($model, $updField = null);

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

    /**
     * 
     * @param string $property
     * @return Field
     */
    public function getFieldByProperty($property);

    /**
     * 
     * @param string $dbName
     * @return Field
     */
    public function getFieldByDB($dbName);
}
