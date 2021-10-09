<?php

namespace Linko\Tools\DB\Fields;

/**
 * Description of DBFiledsFilter
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class DBFiledsFilter {

    static public function filter($fields, string $exclusion) {
        $filterdField = [];
        foreach ($fields as $field) {
            if (false === self::isExcluded($field, $exclusion)) {
                $filterdField[] = $field;
            }
        }
        return $filterdField;
    }

    static private function isExcluded(DBField $field, string $exclusion) {
        return (in_array($exclusion, $field->getExclusions()));
    }

}
