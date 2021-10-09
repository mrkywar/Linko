<?php

namespace Linko\Managers;

use Linko\Managers\Core\SuperManager;
use Linko\Managers\Deck\Deck;
use Linko\Models\Card;
use Linko\Serializers\Serializer;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardManager extends SuperManager {

    public function initForNewGame(array $options = array()) {
        $deck = new Deck();
        
        $this->create($deck->getCards());
       

    }
    
    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstracts Methods 
     * ---------------------------------------------------------------------- */

    protected function initSerializer(): Serializer {
        return new Serializer(Card::class);
    }

}
