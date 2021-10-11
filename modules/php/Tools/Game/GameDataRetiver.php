<?php

namespace Linko\Tools\Game;

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
            "draw" => self::retriveDraw()
        ];
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Retrive Tools (private)
     * ---------------------------------------------------------------------- */

    static private function retriveDraw() {
        $rawCards = self::$cardManager->getCardInDraw();
        return self::$cardSerializer->unserialize($rawCards);
    }

}
