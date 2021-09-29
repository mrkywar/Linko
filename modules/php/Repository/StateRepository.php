<?php

namespace Linko\Repository;

use DateTime;
use Linko\Managers\Logger;
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
        } elseif (!empty($states) && sizeof($states) > 1) {
            return $states[1];
        }
        return;
    }

    public function getLastState() {
        $states = $this->getAll();

        if ($states instanceof State) {
            return $states;
        } elseif (!empty($states)) {
            return $states[sizeof($states) - 1];
        }
        return;
    }

    public function closeState(State $state) {
        $closeField = $this->getFieldByProperty("playedDate");
        $primary = $this->getPrimaryField();

        $state->setPlayedDate(new DateTime());

        $qb = $this->getQueryBuilder()
                ->update()
                ->addSetter($closeField, $state->getPlayedDate())
                ->addClause($primary, $state->getId());

        $this->execute($qb);

        return $state;
    }

    public function getNextOrder() {
        $lastState = $this->getLastState();
        if (null === $lastState) {
            Logger::log("NO STATE ..??");
            return 1;
        } else {
            Logger::log("STATE Order : " . $lastState->getOrder());
            return $lastState->getOrder() + 1;
        }
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Update 
     * ---------------------------------------------------------------------- */

    public function update(State $state) {
        $orderField = $this->getFieldByProperty("order");
        $primary = $this->getPrimaryField();

        $qb = $this->getQueryBuilder()
                ->update()
                ->addSetter($orderField, $state->getOrder())
                ->addClause($primary, $state->getId());

        $this->execute($qb);
        return $state;
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Override 
     * ---------------------------------------------------------------------- */

    public function getAll() {
        $qb = $this->buildGetAll();

        return $this->execute($qb);
    }

}
