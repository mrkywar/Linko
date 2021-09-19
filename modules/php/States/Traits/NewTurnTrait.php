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
        Logger::log("Begin Start of A Player Turn","SSOT");
        $activePlayer = $this->activeNextPlayer();
        Logger::log("Active Player : ".$activePlayer,"SSOT");
        
        $stateManager = $this->getStateManager();
        $stateRepo = $stateManager->getRepository();
        $stateOrder = $stateRepo->getNextOrder();
        
        $states =[];
        $states[] = StateFactory::create(ST_PLAYER_PLAY_NUMBER, $stateOrder, $activePlayer);
        $states[] = StateFactory::create(ST_END_OF_TURN, $stateOrder);
        
        $stateRepo->create($states);
        $stateManager->closeActualState();
        
        Logger::log("Player Turn is created","SSOT");
        $this->gamestate->nextState();
    }

    public function stResolveState() {
        Logger::log("Begin Resolve State","SRS");
        $stateRepo = $this->getStateManager()->getRepository();
        $actualState = $stateRepo->getActualState();
        if (null === $actualState) {
            Logger::log("No actual state","SRS");
        }else{
            Logger::log("Actual state : ".$actualState->getId(),"SRS");
        }
//        $globalManger = \Linko\Managers\Factories\GlobalVarManagerFactory::create();
//        $globalManger->
//        $activePlayer = Linko::getInstance()->getCurrentPlayer();
//        var_dump($activePlayer);
//        die;
    }

}
