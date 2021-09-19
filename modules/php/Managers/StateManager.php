<?php

namespace Linko\Managers;

use Linko\Managers\Core\Manager;
use Linko\Managers\Exception\StateManagerException;
use Linko\Managers\Factories\StateManagerFactory;
use Linko\Models\Factories\StateFactory;

//$filePath = dirname(__FILE__);
//$find = substr($filePath, 0, strpos($filePath, "modules/"));
//
//require_once ($find . '/modules/constants.inc.php');

/**
 * toolbox to manage players
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class StateManager extends Manager {
    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstract Methods
     * ---------------------------------------------------------------------- */

    protected function buildInstance(): Manager {
        return StateManagerFactory::create($this); // factory construct !
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - init
     * ---------------------------------------------------------------------- */

    /**
     * new game initilaze
     * @param array<Player> $players : List of player array<Player> /!\ Not used at the moment
     * @param array $options : /!\ Not used at the moment
     */
    public function initForNewGame(array $players = array(), array $options = array()) {
        $stateOrder = 1;
        $states = [];
        $states[] = StateFactory::create(ST_START_OF_TURN, $stateOrder);
        
        $this->getRepository()->create($states); 
    }

//    public function initForNewGame(array $players = array(), array $options = array()) {
//        $nextTurn = new State();
//        $nextTurn->setOrder(1)
//                ->setState(ST_START_OF_TURN);
//
//        $this->getRepository()->create($nextTurn);
//    }
//
//    public function initNewTurn(array $players = array()) {
//        $stateRepo = $this->getRepository();
//        $lastState = $stateRepo->getLastState();
//
//        if (null === $lastState) {
//            Logger::log("NO STATE ..??");
//            $order = 1;
//        } else {
//            Logger::log("STATE Order : " . $lastState->getOrder());
//            $order = $lastState->getOrder() + 1;
//        }
//
//        $newStates = [];
//        foreach ($players as $player) {
//            $state = new State();
//            $state->setOrder($order)
//                    ->setPlayerId($player->getId())
//                    ->setState(ST_PLAYER_PLAY_NUMBER);
//
//            $order++;
//            $newStates[] = $state;
//        }
//
//        $nextTurn = new State();
//        $nextTurn->setOrder($order)
//                ->setState(ST_END_OF_TURN);
//
//        $newStates[] = $nextTurn;
//
//        $stateRepo->create($newStates);
//    }

    public function closeActualState() {
        $actualState = $this->getRepository()->getActualState();
        if (null === $actualState) {
            throw new StateManagerException("No State To Close !");
        } else {
            $this->getRepository()->closeState($actualState);
        }

        return $this->getRepository()->getActualState();
    }

}
