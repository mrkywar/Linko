<?php

namespace Linko\Tools\Game;

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
     * @var Serializer
     */
    private $cardSerializer;
    private $collection = [];

    /**
     * 
     * @var Card
     */
    private $firstCard;

    /**
     * 
     * @var bool
     */
    private $doSerialization;

    public function __construct() {
        $cardManager = new CardManager();
        $this->doSerialization = true;

        $this->cardSerializer = $cardManager->getSerializer();
    }

    public function setDoSerialization(bool $doSerialization) {
        $this->doSerialization = $doSerialization;
        return $this;
    }

    public function parse($cards) {
        if ($cards instanceof Card) {
            if (null === $this->firstCard) {
                $this->firstCard = $cards;
            }
            if ($this->doSerialization) {
                $this->collection[$cards->getLocationArg()][] = $this->cardSerializer->serialize($cards);
            } else {
                $this->collection[] = $cards;
            }
        } else {
            foreach ($cards as $card) {
                $this->parse($card);
            }
        }

        if ($this->doSerialization) {
            return $this->collection;
        } else {
            return $this;
        }
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
