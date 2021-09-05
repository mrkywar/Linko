<?php

namespace Linko\Managers;

use Linko\Managers\Deck\Deck;
use Linko\Models\Card;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardManager extends Manager {

    private CONST TYPES_OF_NUMBERS = 13; // 13 different number in a deck
    private CONST NUMBER_OF_NUMBERS = 8; // 8 cards of each number in a deck
    private CONST VALUE_OF_JOKERS = 14; // 14 is jocker value when play alone
    private CONST NUMBER_OF_JOKERS = 5; // 5 joker in a deck
    private CONST INTIALS_CARD = 13; // 13 cards in hand at begining
    private CONST VISIBLE_DRAW = 6; // 6 cards visible in the draw

//    CONST DECK_NAME = "deck";

    private $deck;

    /* -------------------------------------------------------------------------
     *                  BEGIN - New Game Initialization
     * ---------------------------------------------------------------------- */

    public function initNewGame(array $players = array(), $options = null) {
        $this->initDeck();

        //-- Give initals cards
        foreach (array_keys($players) as $playerId) {
            $this->deck
                    ->drawCards(self::INTIALS_CARD, Deck::HAND_NAME, $playerId);
        }

        //-- Init visible Draw
        $this->deck
                ->drawCards(self::VISIBLE_DRAW, Deck::DRAW_NAME);
    }

    private function initDeck() {
        $this->deck = new Deck();
        $this->deck->setRepository($this->repository);

        $deck = [];
        for ($number = 1; $number <= self::TYPES_OF_NUMBERS; ++$number) {
            for ($ex = 1; $ex <= self::NUMBER_OF_NUMBERS; ++$ex) {
                $deck[] = $this->createCard($number);
            }
        }
        for ($jok = 1; $jok <= self::NUMBER_OF_JOKERS; ++$jok) {
            $deck[] = $this->createCard(self::VALUE_OF_JOKERS);
        }

        shuffle($deck);
        $count = sizeof($deck);
        for ($order = 0; $order < $count; ++$order) {
            $deck[$order]->setLocationArg($count - $order);
        }

        $this->deck
                ->setCards($deck);

        return $this;
    }

    private function createCard($cardValue, $location = Deck::DECK_NAME) {
        $card = new Card();
        $card->setLocation($location)
                ->setType($cardValue)
                ->setTypeArg($cardValue)
                ->setId(null);

        return $card;
    }

    //    public function getDeckCards() {
//        return $this->getRepository()
//                        ->getCardsInLocation(self::DECK_NAME);
//    }
}
