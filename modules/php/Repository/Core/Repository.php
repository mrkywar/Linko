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
    
}
