<?php

namespace Linko\Tools\DB;

use Linko\Models\Core\Model;
use Linko\Tools\DB\Exceptions\DBValueRetriverException;
use Linko\Tools\DB\Fields\DBField;

/**
 * Description of DBValueRetriver
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class DBValueRetriver {

    static public function retrive(DBField $field, $items) {
        $getter = "get".ucfirst($field->getProperty());
        if($items instanceof Model){
            return $items->$getter();
        } elseif (is_array($items)) {
            $values =[];
            foreach ($items as $item){
                $values[] = self::retrive($field, $item);
            }
            return $values;
        }else{
            var_dump($items);
            throw new DBValueRetriverException("Unsupported call - ERROR CODE : DBVR-01");
        }
        
        
        
    }

}
