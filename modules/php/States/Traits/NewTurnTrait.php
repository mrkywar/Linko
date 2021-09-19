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
        Logger::log("Begin Start of A Player Turn", "SSOT");
        $activePlayer = $this->activeNextPlayer();
        Logger::log("Active Player : " . $activePlayer, "SSOT");
        self::giveExtraTime($activePlayer);

        $stateManager = $this->getStateManager();
        $stateRepo = $stateManager->getRepository();
        $stateOrder = $stateRepo->getNextOrder();

        $states = [];
        $states[] = StateFactory::create(ST_PLAYER_PLAY_NUMBER, $stateOrder, $activePlayer);
        $states[] = StateFactory::create(ST_END_OF_TURN, $stateOrder);

        $stateRepo->create($states);
        $stateManager->closeActualState();

        Logger::log("Player Turn is created", "SSOT");
        $this->gamestate->nextState();
    }

    public function stResolveState() {
        Logger::log("Begin Resolve State", "SRS");
        $stateManager = $this->getStateManager();
        $stateRepo = $stateManager->getRepository();
        $actualState = $stateRepo->getActualState();
        if (null === $actualState) {
            Logger::log("No actual state", "SRS");
            throw new StateManagerException("End Of State Stack");
        } else {
            Logger::log("Actual state : " . $actualState->getId(), "SRS");
        }

//        $stateManager->closeActualState();
        switch ($actualState->getState()) {
            case ST_RESOLVE_STATE:
                Logger::log("Actual Mechanical State");
                $stateManager->closeActualState();
                $this->stResolveState();
                break;
            case ST_PLAYER_PLAY_NUMBER:
                Logger::log("Player should play");
                break;
            default :
                Logger::log("Default case : " . $actualState->getState());
        }
//        $this->gamestate->nextState($actualState->getState());
    }

}
