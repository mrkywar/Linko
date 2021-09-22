<?php

namespace Linko\States\Traits;

use Linko\Managers\Logger;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait EndTurnTrait {

    public function stEndOfTurn() {
        Logger::log("END OF TURN !");
        $this->gamestate->jumpToState(ST_PLAYER_PLAY_NUMBER);// tempory back to player
        //ST_PLAYER_PLAY_NUMBER
    }

}
