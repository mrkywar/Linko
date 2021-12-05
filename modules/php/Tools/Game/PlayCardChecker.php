<?php

namespace Linko\Tools\Game;

use Linko\Models\Card;
use Linko\Models\Player;
use Linko\Tools\Game\Exceptions\PlayCardException;
use Linko\Tools\Game\Exceptions\PlayerCheatException;
use Linko\Tools\Logger\Logger;

/**
 * Description of PlayCardChecker
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayCardChecker {

    /**
     * 
     * @var CollectionParser
     */
    private $collectionParser;

    public function __construct() {
        $this->collectionParser = new CollectionParser();
        $this->collectionParser->setDoSerialization(false);
    }

    public function check(Player $player, $cards) {
        $collection = $this->collectionParser->parse($cards);

        try {
            return $this->checkCollection($collection, $player);
        } catch (PlayerCheatException $ex) {
            Logger::log("Player Cheat with ids : " . $this->getCardsIds($cards));
            throw new PlayCardException("Impossible to play this card(s)", 0, $ex);
        }
    }

    private function checkCollection($cardCollection, Player $player) {
        $cardTypes = [];

        foreach ($cardCollection as $card) {
            if (!$this->checkCardInHand($card, $player)) {
                throw new PlayerCheatException("Invalid Player Selection");
                // return false;
            }

            if (isset($cardTypes[$card->getType()])) {
                $cardTypes[$card->getType()]++;
            } else {
                $cardTypes[$card->getType()] = 1;
            }
        }


        if (!$this->checkCardTypes($cardTypes)) {
            throw new PlayCardException("Invalid Card Selection");
        }

        $log = $player->getName() . " play " . sizeof($cardCollection)
                . " cards : " . $this->getLogType($cardTypes) . " (ids : "
                . $this->getCardsIds($cardCollection) . ")";
        Logger::log($log, "PlayCard");

        return true;
    }

    private function checkCardInHand(Card $card, Player $player) {
        if (!$card->isInHand($player)) {
            $log = $player->getName() . " play fail to play one card  : "
                    . $card->getType() . " (id : " . $card->getId() . " )";
            Logger::log($log, "CHEAT-PC");

            return false;
        }
        return true;
    }

    private function getCardsIds($cards) {
        if ($cards instanceof Card) {
            return $cards->getId();
        } elseif (is_array($cards)) {
            $ids = [];
            foreach ($cards as $card) {
                $ids[] = $this->getCardsIds($card);
            }
            return implode(",", $ids);
        } else {
            throw new PlayCardException("Cards arg fail - PCC 02");
        }
    }

    private function checkCardTypes(array $cardTypes) {
        switch (sizeof($cardTypes)) {
            case 1:// One Type is OK !
                return true;
            case 2:// 2 type = 1 (or more) joker or invalid!
                return isset($cardTypes[14]);
            default ://More or Less is not a valid selection
        }
    }

    private function getLogType(array $cardTypes) {
        $line = [];

        foreach ($cardTypes as $type => $count) {
            $line [] = $count . " x " . $type;
        }

        return implode(" and ", $line);
    }

    /**
     * -------------------------------------------------------------------------
     *              Version 1 
     * -------------------------------------------------------------------------
     */
//    public function check(Player $player, $cards) {
//        try {
//            if ($cards instanceof Card) {
//                $this->checkCardInHand($cards, $player);
//
//                $log = $player->getName() . " play one card : "
//                        . $cards->getType() . " (id : " . $cards->getId() . " )";
//
//                Logger::log($log, "PlayCard");
//
//                return true;
//            } else {
//                $cardTypes = [];
//                foreach ($cards as $card) {
//                    if (!$this->checkCardInHand($card, $player)) {
//                        throw new PlayerCheatException("Invalid Player Selection");
//                    }
//                   
//                }
//
//                if (!$this->checkCardTypes($cardTypes)) {
//                    throw new PlayCardException("Invalid Card Selection");
//                }
//
//                $log = $player->getName() . " play " . sizeof($cards)
//                        . " cards : " . $this->getLogType($cardTypes) . " (ids : "
//                        . $this->getCardsIds($cards) . ")";
//                Logger::log($log, "PlayCard");
//
//                return true;
//            }
//        } catch (PlayerCheatException $ex) {
//            Logger::log("Player Cheat with ids : " . $this->getCardsIds($cards));
//            throw new PlayCardException("Impossible to play this card(s)", 0, $ex);
//        }
//    }
//
//
//
//    static 
}
