<?php

namespace Linko\Tools\DB\Fields;

use Linko\Models\Core\Model;
use Linko\Models\Player;
use Linko\Tools\DB\Exceptions\DBFieldsRetriverException;
use ReflectionClass;
use ReflectionProperty;

abstract class DBFieldsRetriver {

    private const ORM_PROPERTY = "@ORM\Column";
    private const ORM_ID = "@ORM\Id";
    private const EXCLUDE_PROPERTY = "exclude";

    static public function retrive($item, ?string $exclusion = null) {
        if (is_array($item)) {
            return self::retrive($item[array_keys($item)[0]]); //recursive call shoud called with first item in array<Model> parameter
        } elseif ($item instanceof Model) {
            $allField = self::retriveFields($item);
            if(null !== $exclusion){
                return DBFiledsFilter::filter($allField, $exclusion);
            }
            return $allField;
        } else {
            var_dump($item, $item instanceof Player);
            throw new DBFieldsRetriverException("Unsupported call for : " . $item . " - ERROR CODE : DBFR-01");
        }
    }

    static private function retriveFields($classModel) {
        $reflexion = new ReflectionClass($classModel);
        $fields = [];
        foreach ($reflexion->getProperties() as $property) {
            //-- Retrive property first
            $obj = self::getColumDeclaration($property);
            $field = new DBField();
            $field->setDbName($obj->name)
                    ->setType($obj->type)
                    ->setProperty($property->getName())
                    ->setIsPrimary(self::isIdDeclaration($property)); //-- Retrive Id status

            $propertyName = self::EXCLUDE_PROPERTY;
            if (property_exists($obj, $propertyName)) {
                $field->setExclusions($obj->$propertyName);
            }

            $fields[] = $field;
        }
        return $fields;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Primary Tools
     * ---------------------------------------------------------------------- */

    /**
     * Allow you to now if the given Property is a primarty or not
     * @param ReflectionProperty $property
     * @return type
     */
    static private function isIdDeclaration(ReflectionProperty $property) {
        $strpos = strpos($property->getDocComment(), self::ORM_ID);
        return ($strpos >= 0);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Properties Tools
     * ---------------------------------------------------------------------- */

    /**
     * Allow you to get all ORM\Columns declaration properties of a given Property
     * @param ReflectionProperty $property
     * @return type
     */
    static private function getColumDeclaration(ReflectionProperty $property) {
        $strpos = strpos($property->getDocComment(), self::ORM_PROPERTY);
        if ($strpos < 0) {
            return;
        }
        $strpos += strlen(self::ORM_PROPERTY);

        $chaine = substr($property->getDocComment(), $strpos);
        $jsonStr = substr($chaine, 0, strpos($chaine, "}") + 1);
        return json_decode($jsonStr);
    }

}
