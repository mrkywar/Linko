<?php

namespace Linko\Managers\Deck;

use Linko\Repository\CardRepository;

/**
 * Deck is to manage cards (draw, move, ...)
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
        return $this->getRepository()
                        ->getAll();
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

    /**
     * Allows you to take a given number of cards from the deck and put them 
     * elsewhere
     * 
     * @param int $numberOfCards : The number of cards to draw
     * @param string $destination : The wording of the destination
     * @param string $destinationArg : Additional information about the 
     * destination
     * 
     * @throws DeckException
     */
    public function drawCards(int $numberOfCards, string $destination, string $destinationArg = null) {
        $cards = $this->getRepository()
                ->getCardsInLocation(self::DECK_NAME, null, $numberOfCards);

        //-- Check that the number of cards drawn is the one requested 
        // (there is still enough cards available) if not, triggers an exception
        if (sizeof($cards) !== $numberOfCards) {
            throw new DeckException("Not enouth cards aviable");
        }

        //-- Now move cards to their destination
        $this->getRepository()
                ->moveCardsToLocation($cards, $destination, $destinationArg);
    }

}
