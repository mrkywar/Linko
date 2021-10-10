<?php

namespace Linko\Managers\Deck;

use Linko\Models\Card;

/**
 * Description of Deck
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Deck {

    CONST LOCATION_DRAW = "draw";
    CONST LOCATION_POOL = "poule"; // joke name for pool
    CONST LOCATION_HAND = "hand";
    CONST LOCATION_DISCARD = "discard";
    CONST LOCATION_PLAYER_TABLE = "player_table";
    CONST LOCATION_COLLECTION = "collection";
    //-- CARDS
    CONST CARD_DIFFERENT_NUMBER = 13; // Number of different values in a deck
    CONST CARD_NUMBER_COPIES = 8; // Number of copies for different card values in a deck
    CONST CARD_JOKERS_VALUE = 14; // Joker value when play alone
    CONST CARD_JOKERS_COPIES = 5; // Number of Joker copies in a deck
    //-- DECK 
    CONST DECK_INITIAL_HAND = 13; // Number of cards initially in hand
    //-- DRAW
    CONST DRAW_VISIBLE_CARDS = 6; // Number of cards visible in the draw pile

    private $cards;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Constructor
     * ---------------------------------------------------------------------- */

    public function __construct() {
        $id = 1;

        for ($number = 1; $number <= self::CARD_DIFFERENT_NUMBER; ++$number) {
            for ($ex = 1; $ex <= self::CARD_NUMBER_COPIES; ++$ex) {
                $this->cards[] = $this->createCard($number, $id);
                $id++;
            }
        }
        for ($jok = 1; $jok <= self::CARD_JOKERS_COPIES; ++$jok) {
            $this->cards[] = $this->createCard(self::CARD_JOKERS_VALUE, $id);
            $id++;
        }

        shuffle($this->cards);
    }

    private function createCard(int $type, int $id) {
        $card = new Card();

        $card->setId($id)
                ->setLocation(self::LOCATION_DRAW)
                ->setType($type);

        return $card;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters
     * ---------------------------------------------------------------------- */

    public function getCards() {
        return $this->cards;
    }

}
