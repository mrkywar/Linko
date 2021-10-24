<?php

namespace Linko\Tools\Game;

use Linko\Managers\CardManager;
use Linko\Managers\Deck\Deck;
use Linko\Managers\PlayerManager;
use Linko\Models\Card;
use Linko\Models\CardCollection;
use Linko\Serializers\Serializer;

/**
 * Description of CollectionParser
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CollectionParser {

    /**
     * @var Serializer
     */
    private $cardSerializer;
    /**
     * @var PlayerManager
     */
    private $playerManager;
    private $collection = [];

    /**
     * @var bool
     */
    private $doSerialization = true;

    public function __construct() {
        $cardManager = new CardManager();

        $this->cardSerializer = $cardManager->getSerializer();
    }

    public function parse($cards) {

        if ($cards instanceof Card) {
            if ($this->doSerialization) {
                $this->collection[$cards->getLocationArg()][] = $this->cardSerializer->serialize($cards);
            } else {
                $collection = new CardCollection();
                var_dump($cards);die;
                $collection->setCards($cards);
                $player = $this->getPlayerOwner($cards[0]);
                var_dump($player);
                
                $this->collection[$cards->getLocationArg()][] = $cards;
            }
        } else {
            foreach ($cards as $card) {
                $this->parse($card);
            }
        }

        return $this->collection;
    }
    
    private function getPlayerOwner(Card $card) {
        $pId = substr($card->getLocation(), strrpos($card->getLocation(), "_")+1);
        var_dump($pId);die;
    }


    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */
    
    public function getDoSerialization(): bool {
        return $this->doSerialization;
    }

    public function setDoSerialization(bool $doSerialization) {
        $this->doSerialization = $doSerialization;
        return $this;
    }



}
