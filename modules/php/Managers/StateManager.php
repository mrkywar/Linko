<?php

namespace Linko\Managers;

use Linko\Managers\Core\SuperManager;
use Linko\Models\Factories\StateFactory;
use Linko\Models\Player;
use Linko\Models\State;
use Linko\Serializers\Serializer;
use Linko\Tools\DB\QueryBuilder;
use Linko\Tools\DB\QueryString;

/**
 * Description of StateManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class StateManager extends SuperManager {

    public function initNewTurn(Player $player) {
        $states = [];
        $order = $this->getNextOrder();

        $states[] = StateFactory::create(ST_START_OF_TURN, $player->getId(), $order);
        $states[] = StateFactory::create(ST_PLAYER_PLAY_NUMBER, $player->getId(), $order);
        $states[] = StateFactory::create(ST_END_OF_TURN, $player->getId(), $order);

        $this->create($states);

        return $states;
    }

    /**
     * 
     * @return State
     */
    public function getActualState() {
        $qb = $this->prepareFindBy()
                ->addClause($this->getFieldByProperty("playedAt"), null)
                ->addOrderBy($this->getFieldByProperty("order"), QueryString::ORDER_ASC)
                ->setLimit(1);
        return $this->getSerializer()->unserialize($this->execute($qb));
    }

    public function closeActualState() {
        $state = $this->getActualState();
        $state->setPlayedAt(new \DateTime());
 
        $qb = $this->prepareUpdate($state);
        $qb->addSetter($this->getFieldByProperty("playedAt"), $state->getPlayedAt());
                
        $this->execute($qb);
        
        return $this->getActualState();
    }

    public function getNextOrder() {
        $qb = new QueryBuilder();
        $table = $this->getTable();

        $qb->select()
                ->setTable($table)
                ->addFunctionField("max", $this->getFieldByProperty("order"));

        $rawResults = $this->execute($qb);
        $state = $this->getSerializer()->unserialize($rawResults);

        return $state->getOrder() + 1;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstracts Methods 
     * ---------------------------------------------------------------------- */

    protected function initSerializer(): Serializer {
        return new Serializer(State::class);
    }

}
