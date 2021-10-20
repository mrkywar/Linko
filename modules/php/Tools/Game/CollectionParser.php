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
     * @var Serializer
     */
    private $cardSerializer;
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
                $this->collection[$cards->getLocationArg()][] = $cards;
            }
        } else {
            foreach ($cards as $card) {
                $this->parse($card);
            }
        }

        return $this->collection;
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
