<?php

namespace Linko\Tools\DB;

/**
 * Description of DBTableRetriver
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class DBTableRetriver {

    private const PROPERTY_TABLE = "@ORM\Table";

    public static function retrive($classModel) {
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
