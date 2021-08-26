<?php

namespace Linko\Tools;

use Linko\Repository\Core\Repository;


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
                return "'" . addslashes($value) . "'";
            case Repository::BOOLEAN_FORMAT:
                return (true === $value) ? 1 : 0;
            case Repository::INTEGER_FORMAT:
                return "'" . (int) $value . "'";
            default:
                return $value;
        }
    }

}
