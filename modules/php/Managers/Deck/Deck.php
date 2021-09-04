<?php

namespace Linko\Managers\Deck;

use Linko\Repository\CardRepository;

/**
 * Description of DeckManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Deck {

    CONST DECK_NAME = "deck";
    CONST DRAW_NAME = "draw";
    CONST HAND_NAME = "hand";

    /**
     * @var CardRepository
     */
    private $repository;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getCards() {
        return $this->getRepository()->getAll();
    }

    public function setCards($cards) {
        $this->getRepository()
                ->create($cards);
        return $this;
    }

    public function getRepository(): CardRepository {
        return $this->repository;
    }

    public function setRepository(CardRepository $repository) {
        $this->repository = $repository;
        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Draw Cards
     * ---------------------------------------------------------------------- */

    public function drawCards($numberOfCards, $location, $locationArg = null) {
        $cards = $this->getRepository()
                //->setIsDebug(true)
                ->getCardsInLocation(self::DECK_NAME, null, $numberOfCards);
        
        if (sizeof($cards) !== $numberOfCards) {
            throw new DeckException("Not enouth cards aviable");
        }
        var_dump($cards);die;
        
        
        $this->getRepository()
                ->moveCardsToLocation($cards, $location, $locationArg);
//
//        return $this;
    }

}
