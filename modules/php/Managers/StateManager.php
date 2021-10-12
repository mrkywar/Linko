<?php

namespace Linko\Managers;

use Linko\Managers\Core\SuperManager;
use Linko\Models\State;
use Linko\Serializers\Serializer;
use Linko\Tools\DB\QueryBuilder;

/**
 * Description of StateManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class StateManager extends SuperManager {

//    public function initNewTurn(){
//        $states = [];
//        
//        $states = new State();
//        $states->setState(ST_PLAYER_PLAY_NUMBER)
//                ->set;
//        
//        
//        
//    }
    
    
    

    public function initNewTurn() {
        $states = [];
        $order = $this->getNextOrder();
    }

    public function getNextOrder() {
        $qb = new QueryBuilder();
        $table = $this->getTable();

        $qb->select()
                ->setTable($table)
                ->addFunctionField("max", $this->getFieldByProperty("order"));

        $rawResults = $this->setIsDebug(true)->execute($qb);
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
