<?php

namespace Linko\Tools\Game;

use Linko\Collection\CollectionDataRetriver;
use Linko\Managers\CardManager;
use Linko\Managers\PlayerManager;
use Linko\Models\Player;
use Linko\Serializers\Serializer;

/**
 * Description of GameDataRetiver
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class GameDataRetiver {

    /**
     * @var PlayerManager
     */
    static private $playerManager;

    /**
     * @var Serializer
     */
    static private $playerSerializer;

    /**
     * @var CardManager
     */
    static private $cardManager;

    /**
     * @var Serializer
     */
    static private $cardSerializer;

    static public function retriveForPlayer(Player $player) {
        self::$playerManager = new PlayerManager();
        self::$playerSerializer = self::$playerManager->getSerializer();
        self::$cardManager = new CardManager();
        self::$cardSerializer = self::$cardManager->getSerializer();

        return [
            "pool" => self::retrivePool(),
            "deck" => count(self::retriveDeck()),
            "discard" => self::retriveDiscard(),
            "currentPlayer" => self::$playerSerializer->serialize($player),
            "players" => self::retrivePlayers(),
            "tableInfos" => self::retriveTableInfos(),
            "hand" => self::retrivePlayerHand($player)
        ];
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Retrive Cards Tools (private)
     * ---------------------------------------------------------------------- */

    static private function retrivePool() {
        $cards = self::$cardManager->getCardInPool();
        return self::$cardSerializer->serialize($cards);
    }

    static private function retriveDeck() {
        $cards = self::$cardManager->getCardInDraw();
        return self::$cardSerializer->serialize($cards);
    }

    static private function retriveDiscard() {
        $cards = self::$cardManager->getCardInDiscard();
        return self::$cardSerializer->serialize($cards);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Retrive Players Tools (private)
     * ---------------------------------------------------------------------- */

    static private function retrivePlayers() {
        $players = self::$playerManager->findBy();
        $rawPlayers = [];
        foreach ($players as $player) {
            $rawPlayers[$player->getId()] = self::$playerSerializer->serialize($player);
        }

        return $rawPlayers;
    }

    static private function retriveTableInfos() {
        $players = self::$playerManager->findBy();
        $tableInfos = [];

        foreach ($players as $player) {
            //$cards = self::$cardManager->getCardPlayedByPlayer($player);
            $collectionDataRetriver = new CollectionDataRetriver();
            $tableInfos[$player->getId()] = $collectionDataRetriver->retrive($player);
        }

        return $tableInfos;
    }

    static private function retrivePlayerHand(Player $player) {
        $cards = self::$cardManager->getCardInHandByPlayer($player);
        return self::$cardSerializer->serialize($cards);
    }

//    $result['handInfos'] = $cardRepo->getHandsInfos($players);
//        $result['currentPlayer'] = $playerRepo
//                ->setDoUnserialization(false)
//                ->getById(Linko::getInstance()->getCurrentPlayerId())[0];
}
