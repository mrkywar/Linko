<?php

namespace Linko\Repository;

use Linko\Models\State;
use Linko\Repository\Core\SuperRepository;
use Linko\Tools\QueryBuilder;

/**
 * PlayerRepository allows you to  manage the Log Model / Data link
 * Call order :
 * [DBRequester] <--> [QueryBuilder] <--> [Repository] <--> [Manager]
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class StateRepository extends SuperRepository {

    private CONST TABLE_NAME = "state";
    private CONST FIELDS_PREFIX = "state_";

    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement SuperRepository
     * ---------------------------------------------------------------------- */

    public function getFieldsPrefix() {
        return self::FIELDS_PREFIX;
    }

    public function getTableName() {
        return self::TABLE_NAME;
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Specific Repository Methods
     * ---------------------------------------------------------------------- */

    /**
     * build the inital query
     * @return QueryBuilder
     */
    private function buildGetAll() {

        return $this->getQueryBuilder()
                        ->select()
                        ->addClause($this->getFieldByProperty("playedDate"), null)
                        ->addOrderBy($this->getFieldByProperty("order", "ASC"));
    }

    public function getActualState() {
        $states = $this->getAll();
        if ($states instanceof State) {
            return $states;
        } elseif (!empty($states)) {
            return $states[0];
        }
        return;
    }

    public function getNextState() {
        $states = $this->getAll();
        if ($states instanceof State) {
            return; // no next state
        } elseif (!empty($states) && !sizeof($states) > 0) {
            return $states[1];
        }
        return;
    }

    public function getLastState() {
        $states = $this->getAll();
        if ($states instanceof State) {
            return $states;
        } elseif (!empty($states) && !sizeof($states) > 0) {
            return $states[sizeof($states) - 1];
        }
        return;
    }
    
    public function closeState(State $state) {
        $closeField = $this->getFieldByProperty("playedDate");
        $primary = $this->getPrimaryField();
        
        $state->setPlayedDate(new \DateTime());
        
        
         $qb = $this->getQueryBuilder()
                ->update()
                ->addSetter($closeField, $state->getPlayedDate())
                ->addClause($primary, $state->getId());
        
        $this->execute($qb);
        
        return $state;
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Override 
     * ---------------------------------------------------------------------- */

    public function getAll() {
        $qb = $this->buildGetAll();

        $this->setDoUnserialization(true);

        return $this->execute($qb);
    }

}
