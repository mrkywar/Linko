<?php

namespace Linko\Managers;

use Linko\Repository\CardRepository;

/**
 * Description of CardManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardManager {

    CONST TYPES_OF_NUMBERS = 13; // 13 different number in a deck
    CONST NUMBER_OF_NUMBERS = 8; // 8 cards of each number in a deck
    CONST VALUE_OF_JOKERS = 14; // 14 is jocker value when play alone
    CONST NUMBER_OF_JOKERS = 5; // 5 joker in a deck
    CONST INTIALS_CARD = 13; // 13 cards in hand at begining
    CONST VISIBLE_DRAW = 6; // 6 cards visible in the draw
    CONST DECK_NAME = "deck";
    CONST DRAW_NAME = "draw";

    private $repository;
    private $deckModule;

    /**
     * 
     * @var CardRepository
     */
    private $serializer;

    public function __construct() {
        $this->repository = new CardRepository();
        $this->serializer = $this->repository->getSerializer();
    }

    public function setDeckModule($deckModule) {
        $this->deckModule = $deckModule;
        return $this;
    }

    public function getDeckModule() {
        return $this->deckModule;
    }

    public function setupNewGame($players) {
        if (null === $this->deckModule) {
            throw new \feException('No deck module loaded : call setDeckModule'
                            . '(self::getNew("module.common.deck")) '
                            . 'before setupNewGame');
        }
        $this->deckModule->init("card");

        $cards = array();
        for ($number = 1; $number <= self::TYPES_OF_NUMBERS; ++$number) {
            $cards[] = array(
                'type' => $number,
                'type_arg' => $number + 1,
                'nbr' => self::NUMBER_OF_NUMBERS
            );
        }

        $this->deckModule->createCards($cards, self::DECK_NAME);
        $this->deckModule->moveAllCardsInLocation(null, self::DECK_NAME);
        $this->deckModule->shuffle(self::DECK_NAME);

//        return $this->prepareCards($players);
        $this->deckModule->pickCardsForLocation(
                self::VISIBLE_DRAW,
                self::DECK_NAME,
                self::DRAW_NAME
        );
        
        return $this;
    }

//    private function prepareCards($players) {
////        foreach (array_keys($players) as $playerId) {
////            
////        }
//
//        
//        return $this;
//    }
}
