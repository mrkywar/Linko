<?php

namespace Linko\Managers;

use Linko\Tools\DB\Fields\DBFieldsRetriver;
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

    public function initNewGame() {
        $states = [];
        $order = $this->getNextOrder();

        $states[] = StateFactory::create(ST_BEGIN_GAME, null, $order);

        $this->create($states);

        return $states;
    }

    public function initNewTurn(Player $player) {
        $states = [];
        $order = $this->getNextOrder();

        $states[] = StateFactory::create(ST_PLAYER_PLAY_NUMBER, $player->getId(), $order);
        $states[] = StateFactory::create(ST_END_OF_TURN, $player->getId(), $order);

        $this->create($states);

        return $states;
    }

    public function initEndOfTurn(Player $player) {
        $this->initNewGame($player);
    }

    public function initEndOfGame() {
        $states = [];
        $order = $this->getNextOrder();

        $states[] = StateFactory::create(ST_SCORE_COMPUTE, null, $order);
        $states[] = StateFactory::create(ST_END_GAME, null, $order);

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

        $results = $this->execute($qb);

        if (!empty($results)) {
            return $this->getSerializer()->unserialize($results);
        }
        return;
    }

    public function initCollectionAttack(Player $player, $collections) {
        $actualState = $this->getActualState();
        $nextOrder = $this->getNextOrder();
        $states = [];
        
        $qb = $this->prepareFindBy()
                ->addClause($this->getFieldByProperty("playedAt"), null)
                ->addOrderBy($this->getFieldByProperty("order"), QueryString::ORDER_ASC);
//        
        $rawResults = $this->execute($qb);
        $results = $this->getSerializer()->unserialize($rawResults);
        unset($results[0]); //remove actual state

        $i = $actualState->getOrder() + 1;
        foreach ($collections as $collection) {
            $states[] = StateFactory::create(ST_PLAYER_ATTACK, $player->getId(), $i);
            $i++;
            $states[] = StateFactory::create(ST_PLAYER_DRAW, $player->getId(), $i);
            $i++;
        }
        
        $this->create($states);

        foreach ($results as &$state) {
            $state->setOrder($state->getOrder()+ sizeof($collections));
            $fieldOrder = DBFieldsRetriver::retriveFieldByPropertyName("order", $state);
            $qb = $this->prepareUpdate($state);
            $qb->addSetter($fieldOrder, $state->getOrder());
            $this->execute($qb);
        }

        //var_dump($actualState, $nextOrder, $states, $collections);
//        var_dump($states);
//        die("SM 110");
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
