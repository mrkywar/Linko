<?php

namespace Linko\Tools\Game;

use Linko\Managers\CardManager;
use Linko\Managers\PlayerManager;
use Linko\Models\Player;

/**
 * Description of CollectionTakeableIdentifier
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CollectionTakeableIdentifier {

    /**
     * @var PlayerManager
     */
    private $playerManager;

    /**
     * @var CardManager
     */
    private $cardManager;

    /**
     * 
     * @var CollectionParser
     */
    private $collectionParser;

    public function __construct() {
        $this->playerManager = new PlayerManager();
        $this->cardManager = new CardManager();
        $this->collectionParser = new CollectionParser();
    }

    public function identify($cards, Player $activePlayer) {
        $players = $this->playerManager->findBy();

        $collections = [];

        foreach ($players as $player) {
            if ($activePlayer->getId() !== $player->getId()) {
                $cards = $this->cardManager->getCardPlayedByPlayer($player);

                $collection = $this->collectionParser->parse($cards);
            }
        }

        return $collections;
    }

    
    
    
    
}
