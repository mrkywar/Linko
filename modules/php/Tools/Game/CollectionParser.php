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
        if($this->doSerialization){
            return $this->collection;
        }else{
            return $this;
        }
    }

}
