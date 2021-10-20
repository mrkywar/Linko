<?php

namespace Linko\Tools\Game;

use Linko\Managers\CardManager;
use Linko\Managers\PlayerManager;
use Linko\Models\Player;

/**
 * Description of CardCollectionTakeable
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

    public function __construct() {
        $this->playerManager = new PlayerManager();
        $this->cardManager = new CardManager();
    }

    public function identify($cards, Player $activePlayer) {
        $players = $this->playerManager->findBy();
        foreach ($players as $player) {
            if ($activePlayer->getId() !== $player->getId()) {
                $cards = $this->cardManager->getCardPlayedByPlayer($player);
                $collectionParser = new CollectionParser();
                $collections = $collectionParser->parse($cards);
                
            }
        }
    }

}
