<?php

namespace Linko\States\Traits;

use Linko\Managers\StateManager;
use Linko\Tools\Logger\Logger;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait TurnTrait {


    /**
     * stStartOfTurn: called at the beggining of each player turn
     * 
     */
    public function stStartOfTurn() {
        Logger::log("Begin Start of A Player Turn", "SSOT");
        
        $player = $this->getPlayerManager()->findBy([
            "id" => $this->getActivePlayerId()
        ]);

        $stateManager = new StateManager();
        $stateManager->initNewTurn($player);
        $stateManager->closeActualState();
        
        $this->gamestate->nextState();
    }

    public function stResolveState() {
//        Logger::log("Begin Resolve State", "SRS");
//        $stateManager = $this->getStateManager();
//        $stateRepo = $stateManager->getRepository();
//        $actualState = $stateRepo->getActualState();
//        if (null === $actualState) {
//            Logger::log("No actual state", "SRS");
//            throw new StateManagerException("End Of State Stack");
//        } else {
//            Logger::log("Actual state : " . $actualState->getState(), "SRS");
//        }
//
//        $this->gamestate->jumpToState($actualState->getState());
//        if (null !== $actualState->getPlayerId()) {
//            $this->gamestate->changeActivePlayer($actualState->getPlayerId());
//        }
        $this->activeNextPlayer();
        $this->gamestate->jumpToState(ST_PLAYER_PLAY_NUMBER);
    }

}
