<?php

namespace Linko\States\Traits;

use Linko\Managers\Logger;
use Linko\Models\Factories\StateFactory;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait NewTurnTrait {
    


    /**
     * stStartOfTurn: called at the beggining of each player turn
     * 
     */
    public function stStartOfTurn() {
        Logger::log("Begin Start of A Player Turn");
        $activePlayer = $this->activeNextPlayer();
        Logger::log("Active Player : ".$activePlayer);
        
        $stateRepo = $this->getStateManager()->getRepository();
        $stateOrder = $stateRepo->getNextOrder();
        
        $states =[];
        $states[] = StateFactory::create(ST_PLAYER_PLAY_NUMBER, $stateOrder, $activePlayer);
        $states[] = StateFactory::create(ST_END_OF_TURN, $stateOrder);
        
        $stateRepo->create($states);
    }

    public function stResolveState() {
        Logger::log("Begin Resolve State");
        $stateRepo = $this->getStateManager()->getRepository();
        $actualState = $stateRepo->getActualState();
        if (null === $actualState) {
            Logger::log("No actual state");
        }else{
            Logger::log("Actual state : ".$actualState->getId());
        }
//        $globalManger = \Linko\Managers\Factories\GlobalVarManagerFactory::create();
//        $globalManger->
//        $activePlayer = Linko::getInstance()->getCurrentPlayer();
//        var_dump($activePlayer);
//        die;
    }

}
