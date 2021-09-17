<?php

namespace Linko\Managers;

use Linko\Managers\Core\Manager;
use Linko\Managers\Factories\StateManagerFactory;
use Linko\Models\State;

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
     * @param array<Player> $players : List of player array<Player>
     * @param array $options : /!\ Not used at the moment
     */
    public function initForNewGame(array $players = array(), array $options = array()) {
        $states = [];
        $order = 1;
        foreach ($players as $player) {
            $state = new State();
            $state->setOrder($order)
                    ->setPlayerId($player->getId())
                    ->setState(ST_PLAYER_PLAY_NUMBER)
            ;
            $order++;
            $states[] = $state;
        }

        $nextTurn = new State();
        $nextTurn->setOrder($order)
                ->setState(ST_END_OF_TURN);

        $states[] = $nextTurn;

        $this->getRepository()->setIsDebug(true)->create($states);
    }

}
