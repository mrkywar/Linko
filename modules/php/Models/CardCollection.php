<?php

namespace Linko\Models;

/**
 * Description of CardCollection
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardCollection {

    /**
     * @var Player
     */
    private $playerOwner;

    /**
     * 
     * @var array<Card>
     */
    private $cards = [];

    // private $index;
    
    /* -------------------------------------------------------------------------
     *                  BEGIN - Adders
     * ---------------------------------------------------------------------- */
    public function addCard(Card $card){
        $this->cards[] = $card;
        return $this;
    }
    
    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getPlayerOwner(): Player {
        return $this->playerOwner;
    }

    public function getCards(): array {
        return $this->cards;
    }

    public function setPlayerOwner(Player $playerOwner) {
        $this->playerOwner = $playerOwner;
        return $this;
    }

    public function setCards(array $cards) {
        $this->cards = $cards;
        return $this;
    }

}
