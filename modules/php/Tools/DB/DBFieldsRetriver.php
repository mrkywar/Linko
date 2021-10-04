<?php

namespace Linko\Tools\DB;

use ReflectionClass;

/**
 * Description of DBFielsRetriver
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class DBFieldsRetriver {

    private const PROPERTY_COLUMN = "@ORM\Column";
    private const PROPERTY_ID = "@ORM\Id";

    public static function retrive($classModel, $searchOnlyId = false) {
        $reflexion = new ReflectionClass($classModel);
        $fields = [];
        foreach ($reflexion->getProperties() as $property) {
            if ($searchOnlyId) {
                $obj = self::getIdDeclaration($property);
            } else {
                $obj = self::getColumDeclaration($property);
            }
            if (null !== $obj) {
                $field = new DBField();
                $field->setName($obj->name)
                        ->setType($obj->type)
                        ->setProperty($property->getName());

                $fields[] = $field;
            }
        }

        return $fields;
    }

    public static function retriveId($classModel) {
        return $this->retrive($classModel, true);
    }

    private static function getIdDeclaration(ReflectionProperty $property) {
        $strpos = strpos($property->getDocComment(), self::PROPERTY_ID);
        if ($strpos < 0) {
            return;
        }
        return self::getColumDeclaration($property);
    }

    private static function getColumDeclaration(ReflectionProperty $property) {
        $strpos = strpos($property->getDocComment(), self::PROPERTY_COLUMN);
        if ($strpos < 0) {
            return;
        }
        $strpos += strlen(self::PROPERTY_COLUMN);

        $chaine = substr($property->getDocComment(), $strpos);
        $jsonStr = substr($chaine, 0, strpos($chaine, "}") + 1);
        return json_decode($jsonStr);
    }

}
