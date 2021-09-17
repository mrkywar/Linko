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
        $nextTurn = new State();
        $nextTurn->setOrder(1)
                ->setState(ST_START_OF_TURN);
        
        $this->getRepository()->create($nextTurn);
        
    }
    
    

}
