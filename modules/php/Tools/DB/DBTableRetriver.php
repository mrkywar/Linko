<?php

namespace Linko\Tools\DB;

use Linko\Models\Core\Model;
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
     * @param type $item
     * @return DBTable
     */
    public static function retrive($item) {
        if (is_array($item)) {
            return self::retrive($item[array_keys($item)[0]]);
        } elseif ($item instanceof Model) {
            $reflexion = new ReflectionClass(get_class($item));
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
        }else{
            var_dump($item);
            throw new DBTableRetriverException("Unsupported call for : " . $item . " - ERROR CODE : DBTR-01");
        }
    }

}
