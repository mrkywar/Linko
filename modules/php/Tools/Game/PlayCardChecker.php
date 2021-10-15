<?php

namespace Linko\Tools\Game;

use Linko\Models\Card;
use Linko\Models\Player;
use Linko\Tools\Logger\Logger;

/**
 * Description of PlayCardChecker
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class PlayCardChecker {

    static public function check(Player $player, $cards) {
//        var_dump($cards);die;

        if ($cards instanceof Card) {

            if (!$cards->isInHand($player)) {
                $log = $player->getName() . " play fail to play one card  : "
                        . $cards->getType() . " (id : " . $cards->getId() . " )";
                throw new PlayCardException("Card isn't in your hand");
            }
            $log = $player->getName() . " play one card : " . $cards->getType()
                    . " (id : " . $cards->getId() . " )";

            Logger::log($log, "PlayCard");
            return true;
        } else {
            $cardTypes = [];
        }

        var_dump($cards);
        die;
    }

}
