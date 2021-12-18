<?php

namespace Linko\Collection;

use Linko\Managers\CardManager;
use Linko\Models\Card;
use Linko\Serializers\Serializer;

/**
 * Description of CollectionParser
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CollectionParser {

    /**
     * 
     * @var Card
     */
    private $firstCard;

    public function __construct() {
        $cardManager = new CardManager();
        $this->collection = new Collection();
//        $this->doSerialization = true;

        $this->cardSerializer = $cardManager->getSerializer();
    }

    public function setDoSerialization(bool $doSerialization) {
        $this->doSerialization = $doSerialization;
        return $this;
    }

    /**
     * 
     * @param Card $cards
     * @return Collection
     */
    public function parse($cards) {
        $collection = new Collection();

        if ($cards instanceof Card) {
            $collection->addCard($cards);
        } else {
            $collection->setCards($cards);
        }

        return $collection;

//        if ($cards instanceof Card) {
//            if (null === $this->firstCard) {
//                $this->firstCard = $cards;
//            }
//            if ($this->doSerialization) {
//                $this->collection[$cards->getLocationArg()][] = $this->cardSerializer->serialize($cards);
//            } else {
//                $this->collection[] = $cards;
//            }
//        } else {
//            $collection = new Collection()
//            
//            foreach ($cards as $card) {
//                $this->parse($card);
//            }
//        }
//
//        if ($this->doSerialization) {
//            return $this->collection;
//        } else {
//            return $this;
//        }
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Fake getter
     * ---------------------------------------------------------------------- */

    public function getCardsNumber() {
        return count($this->collection);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getCardSerializer(): Serializer {
        return $this->cardSerializer;
    }

    public function getCollection() {
        return $this->collection;
    }

    public function getFirstCard(): Card {
        return $this->firstCard;
    }

    public function setCardSerializer(Serializer $cardSerializer) {
        $this->cardSerializer = $cardSerializer;
        return $this;
    }

    public function setCollection($collection) {
        $this->collection = $collection;
        return $this;
    }

    public function setFirstCard(Card $firstCard) {
        $this->firstCard = $firstCard;
        return $this;
    }

}
