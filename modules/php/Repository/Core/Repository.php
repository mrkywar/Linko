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
     *                  BEGIN -  Repository Management
     * ---------------------------------------------------------------------- */
    
    public function getTableName();
    
    public function getFieldsPrefix();


    /**
     * @return Serializer
     */
    public function getSerializer(): Serializer;
    
    public function getFields();

    public function getFieldType($fieldName);
    
    public function getDbFields();


    /* -------------------------------------------------------------------------
     *                  BEGIN - Base queries
     * ---------------------------------------------------------------------- */
    
    public function getAll();
    
    public function create($items);
    
}
