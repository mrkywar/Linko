<?php

namespace Linko\Tools;

use Linko\Repository\Repository;

/**
 * Description of FieldTransposer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class DBFieldTransposer {

    private $repository;

    public function __construct(Repository $repository = null) {
        $this->repository = $repository;
    }

    public function transpose($value, $fieldName) {
        switch ($this->repository->getFieldType($fieldName)) {
            case Repository::STRING_FORMAT:
                return "'" . mysql_escape_string($value) . "'";
            case Repository::BOOLEAN_FORMAT:
                return (true === $value) ? 1 : 0;
            default:
                return $value;
        }
    }

}
