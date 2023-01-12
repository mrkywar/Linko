<?php

namespace Linko\Collection;

use Linko\Managers\CardManager;
use Linko\Models\Card;
use Linko\Models\Player;
use Linko\Serializers\Serializer;

/**
 * Description of CollectionDataRetriver
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CollectionDataRetriver {

    /**
     * 
     * @var Serializer
     */
    private $cardSerializer;
    private $collection = [];

    /**
     * 
     * @var CardManager
     */
    private $cardManager;

//    /**
//     * 
//     * @var bool
//     */
//    private $doSerialization;

    public function __construct() {
        $this->cardManager = new CardManager();
//        $this->doSerialization = true;

        $this->cardSerializer = $this->cardManager->getSerializer();
    }

    public function retrive(Player $player) {
        $cards = $this->cardManager->getCardPlayedByPlayer($player);

        if ($cards instanceof Card) {
            $this->parse($cards);
            //$this->collection[$cards->getLocationArg()][] = $this->cardSerializer->serialize($cards);
        } else {
            foreach ($cards as $card) {
                $this->parse($card);
            }
        }

        return $this->collection;
    }
    
    
    protected function parse(Card $card) {
        $this->collection[$card->getLocationArg()][] = $this->cardSerializer->serialize($card);
        
    }

}
