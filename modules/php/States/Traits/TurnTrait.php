<?php

namespace Linko\States\Traits;

use Linko\Tools\Logger\Logger;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait TurnTrait {

    public function stStartOfTurn() {
        Logger::log("Start Turn", "Game - TT");
        
        

//        Log::startTurn();
//        $player = Players::getActive();
//        Globals::setPIdTurn($player->getId());
//        Stack::setup([ST_DRAW_CARDS, ST_PLAY_CARD, ST_DISCARD_EXCESS, ST_END_OF_TURN]);
//        $player->startOfTurn();
//        Stack::finishState();
    }

}
