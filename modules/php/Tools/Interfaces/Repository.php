<?php
namespace Linko\Tools\Interfaces;
/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
interface Repository {
    public function getTableName();
    
    /**
     * @return Serializer
     */
    public function getSerializer();
    
    //public function getFields();
    
}
