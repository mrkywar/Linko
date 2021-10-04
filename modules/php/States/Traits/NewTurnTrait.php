<?php

namespace Linko\States\Traits;

use Linko\Managers\Exception\StateManagerException;
use Linko\Managers\GlobalVarManager;
use Linko\Managers\Logger;
use Linko\Models\Factories\StateFactory;
use Linko\Models\GlobalVar;

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
        $stateOrder = $stateRepo->setDoUnserialization(true)->getNextOrder();

        $states = [];
        $states[] = StateFactory::create(ST_PLAYER_PLAY_NUMBER, $stateOrder, $activePlayer);
        $states[] = StateFactory::create(ST_END_OF_TURN, $stateOrder, $activePlayer);

        GlobalVarManager::setVar(GlobalVar::ACTIVE_PLAYER, $activePlayer);

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
            Logger::log("Actual state : " . $actualState->getState(), "SRS");
        }
        echo '<pre>';
        var_dump($this->gamestate->state());die;
        
        
        $this->gamestate->jumpToState($actualState->getState());
        if (null !== $actualState->getPlayerId()) {
            $this->
            $this->gamestate->changeActivePlayer($actualState->getPlayerId());
        }
    }

}
