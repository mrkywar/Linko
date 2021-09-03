  
<?php

namespace Linko\Managers;

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
    CONST DECK_NAME = "deck";
    CONST DRAW_NAME = "draw";
    CONST HAND_NAME = "hand";

    private $deck;

    /* -------------------------------------------------------------------------
     *                  BEGIN - New Game Initialization
     * ---------------------------------------------------------------------- */

    public function initNewGame() {
        $this->initDeck();
    }

    private function initDeck() {
        for ($number = 1; $number <= self::TYPES_OF_NUMBERS; ++$number) {
            for ($ex = 1; $ex <= self::NUMBER_OF_NUMBERS; ++$ex) {
                $this->deck[] = $this->createCard($number);
            }
        }
        for ($jok = 1; $jok <= self::NUMBER_OF_JOKERS; ++$jok) {
            $this->deck[] = $this->createCard(self::VALUE_OF_JOKERS);
        }

        shuffle($this->deck);
        $count = sizeof($this->deck);
        for ($order = 0; $order < $count; ++$order) {
            $this->deck[$order]->setLocationArg($count - $order);
        }

        $this->repository
                ->create($this->deck);

        return $this;
    }

    private function createCard($cardValue, $location = self::DECK_NAME) {
        $card = new Card();
        $card->setLocation($location)
                ->setType($cardValue)
                ->setTypeArg($cardValue)
                ->setId(null);

        return $card;
    }

}