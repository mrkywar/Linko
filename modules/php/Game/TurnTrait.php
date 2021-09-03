<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Linko\Game;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait TurnTrait {
    public function stNextPlayer() {
        $player_id = self::activeNextPlayer();
        self::giveExtraTime($player_id);
        $this->gamestate->nextState("nextPlayer");

        //tandard case (not the end of the trick)
        // => just active the next player
        // Active next player OR end the trick and go to the next trick OR end the hand
//        if ($this->cards->countCardInLocation('cardsontable') == 4) {
//            // This is the end of the trick
//            // Move all cards to "cardswon" of the given player
//            $best_value_player_id = self::activeNextPlayer(); // TODO figure out winner of trick
//            $this->cards->moveAllCardsInLocation('cardsontable', 'cardswon', null, $best_value_player_id);
//
//            if ($this->cards->countCardInLocation('hand') == 0) {
//                // End of the hand
//                $this->gamestate->nextState("endHand");
//            } else {
//                // End of the trick
//                $this->gamestate->nextState("nextTrick");
//            }
//        } else {
//            // Standard case (not the end of the trick)
//            // => just active the next player
//            $player_id = self::activeNextPlayer();
//            self::giveExtraTime($player_id);
//            $this->gamestate->nextState('nextPlayer');
//        }
    }
}
