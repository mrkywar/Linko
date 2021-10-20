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
    
    private $takeableCollection = [];

    public function __construct() {
        $this->playerManager = new PlayerManager();
        $this->cardManager = new CardManager();
    }

    public function identify($cards, Player $activePlayer) {
        $players = $this->playerManager->findBy();
        $this->takeableCollection = [];
        foreach ($players as $player) {
//            var_dump()
            if ($activePlayer->getId() !== $player->getId()) {
                $cards = $this->cardManager->getCardPlayedByPlayer($player);
                $collectionParser = new CollectionParser();
                $collections = $collectionParser->parse($cards);
                $this->addTakeableCollection($cards, $collections);
            }
        }
    }

    private function addTakeableCollection($cards, $targetCollections) {
        if (sizeof($targetCollections) > 1) {
            echo '<pre>';
            var_dump($targetCollections);
            die;
        }
    }

}
