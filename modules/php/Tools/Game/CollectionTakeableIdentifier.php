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

    /**
     * @var CollectionParser
     */
    private $collectionParser;
    private $takeableCollection = [];

    public function __construct() {
        $this->playerManager = new PlayerManager();
        $this->cardManager = new CardManager();
        $this->collectionParser = new CollectionParser();
        $this->collectionParser->setDoSerialization(false);
    }

    public function identify(array $cards, Player $activePlayer) {
        $players = $this->playerManager->findBy();
        $this->takeableCollection = [];
        foreach ($players as $player) {
            if ($activePlayer->getId() !== $player->getId()) {
                $playedCards = $this->cardManager->getCardPlayedByPlayer($player);
                $collections = $this->collectionParser->parse($playedCards);
                $this->addTakeableCollection($cards, $collections);
            }
        }
        return $this->takeableCollection;
    }

    private function addTakeableCollection(array $cards, array $targetCollections) {
        if (sizeof($targetCollections) > 0) {
            $keys = array_keys($targetCollections);
            //yeah strange last collection is in first key (but last index)
            $lastCollectionCards = $targetCollections[$keys[0]];

            if($this->isCollectionTakeable($cards, $lastCollectionCards)){
                $this->takeableCollection[] = $lastCollectionCards;
            }
        }
    }

    private function isCollectionTakeable(array $cards, array $targetCollection) {
        return(
                (count($cards) === count($targetCollection)) &&
                ($cards[0]->getType() > $targetCollection[0]->getType())
        );
    }

}
