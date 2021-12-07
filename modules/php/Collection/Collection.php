<?php

namespace Linko\Collection;

/**
 * Description of CollectionRetriver
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Collection {

    /**
     * 
     * @var array
     */
    private $cards = [];

    /* -------------------------------------------------------------------------
     *                  BEGIN - Fake getter
     * ---------------------------------------------------------------------- */

    /**
     * 
     * @return int
     */
    public function getCardsNumber() {
        return count($this->cards);
    }

    /**
     * 
     * @return Card|null
     */
    public function getFirstCard() {
        if (!empty($this->cards)) {
            return $this->cards[0];
        }
        return;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - adder
     * ---------------------------------------------------------------------- */

    public function addCard(Card $card) {
        $this->cards[] = $card;
        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getCards() {
        return $this->cards;
    }

}
