<?php

namespace Linko\Repository\Core;

use Linko\Models\Core\Field;
use Linko\Serializers\Core\Serializer;
use Linko\Tools\DBRequester;
use Linko\Tools\QueryBuilder;

/**
 * Repositories do link between DB & Model
 * Call order :
 * [DBRequester] <--> [QueryBuilder] <--> [Repository] <--> [Manager]
 * 
 * @author Mr_Kywar mr_kywar@gmail.com
 */
interface Repository {
    /* -------------------------------------------------------------------------
     *                  BEGIN - Base queries
     * ---------------------------------------------------------------------- */

    public function getAll();

    public function create($items);

    public function getById($id);

    /* -------------------------------------------------------------------------
     *                  BEGIN - Serializer
     * ---------------------------------------------------------------------- */

    /**
     * 
     * @return Serializer
     */
    public function getSerializer(): Serializer;
    
    public function setSerializer(Serializer $serializer): Repository;
    
    
    /* -------------------------------------------------------------------------
     *                  BEGIN - DB Link
     * ---------------------------------------------------------------------- */
    
    public function getDbRequester(): DBRequester;
    
    public function getQueryBuilder() : QueryBuilder;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Fields Management
     * ---------------------------------------------------------------------- */

    public function getTableName();

    public function getFields(): array;

    public function getFieldsPrefix();

    public function getDbFields(): array;

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
    
    public function setFields(array $fields);
    
    
    /* -------------------------------------------------------------------------
     *                  BEGIN - Debug
     * ---------------------------------------------------------------------- */

    public function getIsDebug(): bool;

    public function setIsDebug(bool $isDebug): Repository;
}
