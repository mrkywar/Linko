<?php

namespace Linko\Tools;

/**
 * Description of QueryBuilder
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class QueryBuilder extends \APP_DbObject {

    private $conditions;
    private $repository;
    //private $typeOfQuery;
    private $sql;

    public function __construct(Interfaces\Repository $repository) {
        $this->conditions = new ArrayCollection();
        $this->repository = $repository;
    }

    private function execute() {
        $results = self::getObjectListFromDB($this->sql);

        switch (sizeof($results)) {
            case 0:
                return null;
            case 1:
                return $this->repository->getSerializer()->unserialize($results[0]);
            default :
                $col = new ArrayCollection();
                foreach ($results as $res) {
                    $col->add($this->repository->getSerializer()->unserialize($res));
                }
                return $col;
        }
    }

    /* --------------------------------------------------------------------------
     *                  BEGIN - SELECT
     * ----------------------------------------------------------------------- */

    private function preapareSelect() {
        $this->sql = "Select * From " . $this->repository->getTableName();
        return $this;
    }

    public function getAll() {
        return $this->preapareSelect()->execute();
    }

}
