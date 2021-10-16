<?php

namespace Linko\Tools\Game;

use Linko\Models\Card;
use Linko\Models\Player;
use Linko\Tools\Game\Exceptions\PlayCardException;
use Linko\Tools\Logger\Logger;

/**
 * Description of PlayCardChecker
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class PlayCardChecker {

    static public function check(Player $player, $cards) {
        try {
            if ($cards instanceof Card) {
                self::checkCardInHand($cards, $player);
            }
        } catch (Exceptions\PlayerCheatException $ex) {
            Logger::log("Player Cheat with ids : " . self::getCardsIds($cards));
            throw new PlayCardException("Impossible to play this card(s)", 0, $ex);
        }



//        if ($cards instanceof Card) {
//
//            if (!$cards->isInHand($player)) {
//                $log = $player->getName() . " play fail to play one card  : "
//                        . $cards->getType() . " (id : " . $cards->getId() . " )";
//                Logger::log($log, "CHEAT-PC01");
//                throw new PlayCardException("Card isn't in your hand");
//            }
//            $log = $player->getName() . " play one card : " . $cards->getType()
//                    . " (id : " . $cards->getId() . " )";
//
//            Logger::log($log, "PlayCard");
//            return true;
//        } else {
//            $cardTypes = [];
//            $checkHand = true;
//
//            foreach ($cards as $card){
//               if (!$card->isInHand($player)) {
//                    $log = $player->getName() . " play fail to play "
//                            . count($cards)." cards  : "
//                        . $cards->getType() . " (id : " . $cards->getId() . " )";
//                    Logger::log($log, "CHEAT-PC02");
//                    throw new PlayCardException("Some Cards isn't in your hand");
//               }
//            }
//        }
//
//        var_dump($cards);
//        die;
    }

    private static function checkCardInHand(Card $card, Player $player) {
        if (!$card->isInHand($player)) {
            $log = $player->getName() . " play fail to play one card  : "
                    . $card->getType() . " (id : " . $card->getId() . " )";
            Logger::log($log, "CHEAT-PC");
        }
    }

    private static function getCardsIds($cards) {
        if ($cards instanceof Card) {
            return $cards->getId();
        } elseif (is_array($cards)) {
            $ids = [];
            foreach ($cards as $card) {
                $ids[] = self::getCardsIds($card);
            }
            return implode(",", $ids);
        } else {
            throw new PlayCardException("Cards arg fail - PCC 02");
        }
    }

}
