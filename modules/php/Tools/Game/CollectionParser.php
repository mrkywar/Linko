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

    public function __construct() {
        $cardManager = new CardManager();

        $this->cardSerializer = $cardManager->getSerializer();
    }

    public function parse($cards) {

        if ($cards instanceof Card) {
            $this->collection[$cards->getLocationArg()][] = $this->cardSerializer->serialize($cards);
        } else {
            foreach ($cards as $card) {
                $this->parse($card);
            }
        }
        
        return $this->collection;
    }

}
