<?php

namespace Linko\Tools\DB;

use ReflectionClass;

/**
 * Description of DBTableRetriver
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class DBTableRetriver {

    private const PROPERTY_TABLE = "@ORM\Table";

    /**
     * Allows you to determine the name of the table used
     * @param type $classModel
     * @return DBTable
     */
    public static function retrive($classModel) {
//        if (is_array($classModel)) {
//            
//        }
        $reflexion = new ReflectionClass($classModel);
        $strpos = strpos($reflexion->getDocComment(), self::PROPERTY_TABLE);
        if ($strpos < 0) {
            return;
        }
        $strpos += strlen(self::PROPERTY_TABLE);

        $chaine = substr($reflexion->getDocComment(), $strpos);
        $jsonStr = substr($chaine, 0, strpos($chaine, "}") + 1);
        $obj = json_decode($jsonStr);

        $table = new DBTable();
        $table->setName($obj->name);
        return $table;
    }

}
