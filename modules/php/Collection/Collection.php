<?php

namespace Linko\Collection;

use Linko\Models\Card;

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
     * count card in the collection
     * @return int
     */
    public function getCardsCount() {
        return count($this->cards);
    }

    /**
     * get associated card value for collection
     * @return int
     */
    public function getCardsValue() {
        return $this->getFirstCard()->getType();
    }

    /**
     * 
     * @return Card
     */
    public function getFirstCard() {
        if (!empty($this->cards)) {
            return $this->cards[0];
        }
        return;
    }

    /**
     * 
     * @param Collection $attackerCollection collection of attaker (who want take collection
     * @return bool
     */
    public function isTakeable(Collection $attackerCollection) {
        return (
                $attackerCollection->getCardsCount() === $this->getCardsCount() &&
                $attackerCollection->getCardsValue() > $this->getCardsValue()
                );
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - adder & fake setter 
     * ---------------------------------------------------------------------- */

    public function addCard(Card $card) {
        $this->cards[] = $card;
        return $this;
    }

    public function setCards(array $cards) {
        foreach ($cards as $card) {
            $this->addCard($card);
        }
        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getCards() {
        return $this->cards;
    }

}
