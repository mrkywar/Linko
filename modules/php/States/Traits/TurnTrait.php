<?php

namespace Linko\States\Traits;

use Linko\Tools\Game\EndOfGameChecker;
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

        $stateManager = $this->getStateManager();
        $stateManager->initNewTurn($player);
        $stateManager->closeActualState();

        $this->gamestate->nextState();
    }

    public function stResolveState() {
        Logger::log("Begin Resolve State", "SRS");
        $stateManager = $this->getStateManager();
        $actualState = $stateManager->getActualState();
        
//        if(null === $actualState)

        if (null !== $actualState->getPlayerId()) {
            $this->gamestate->changeActivePlayer($actualState->getPlayerId());
        }
        $this->gamestate->jumpToState($actualState->getState());
    }

    public function stEndOfTurn() {
        $stateManager = $this->getStateManager();
        $stateManager->closeActualState();
        $playerId = $this->activeNextPlayer();
        $player = $this->getPlayerManager()->findBy([
            "id" => $playerId
        ]);

        //-- Detect End Of Game
        $endOfGameChecker = new EndOfGameChecker();
//        $endOfGame = $checker->check();
        if ($endOfGameChecker->check()) {
            $stateManager->initEndOfGame();
        } else {
            $stateManager->initEndOfTurn($player);
        }
        $this->gamestate->jumpToState(ST_RESOLVE_STATE);
    }

}
