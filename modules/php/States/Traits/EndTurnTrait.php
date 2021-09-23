<?php

namespace Linko\States\Traits;

use Linko\Managers\Logger;
use Linko\Models\Factories\StateFactory;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait EndTurnTrait {

    public function stEndOfTurn() {
        Logger::log("END OF TURN !");
        
        $stateManager = $this->getStateManager();
        $stateRepo = $stateManager->getRepository();
        $stateOrder = $stateRepo->getNextOrder();

        $states = [];
        $states[] = StateFactory::create(ST_START_OF_TURN, $stateOrder);

        $stateRepo->create($states);
         
        $newState = $stateManager->closeActualState();
        Logger::log("NextState : ".$newState->getState());
        $this->gamestate->jumpToState($newState->getState());

    }

}
