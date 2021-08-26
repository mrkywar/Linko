<?php

namespace Linko\Managers;

use Linko\Repository\CardRepository;

/**
 * Description of CardManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardManager {

//    CONST AVAILABLE_CARD = 6;
    CONST TYPES_OF_NUMBERS = 13;
    CONST NUMBER_OF_NUMBERS = 8;
    CONST VALUE_OF_JOKERS = 14;
    CONST NUMBER_OF_JOKERS = 5;

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

    public function setupNewGame() {
        $this->deckModule->init("card");

        $cards = array();
        for ($number = 1; $number <= self::TYPES_OF_NUMBERS; ++$number) {
            $cards[] = array(
                'type' => $number,
                'type_arg' => $number + 1,
                'nbr' => self::NUMBER_OF_NUMBERS
            );
        }
        
        $this->deckModule->createCards($cards, 'deck');
        $this->deckModule->moveAllCardsInLocation(null, "deck");
        $this->deckModule->shuffle('deck');

        return $this;

        // Create cards
        // $this->cards = self::getNew("module.common.deck");
//        $this->cards->init("card");
//        $cards = array();
//        for ($number = 1; $number <= self::NUMBER_OF_NUMBERS; ++$number) {
//            $cards[] = array('type' => $number, 'type_arg' => $number + 1, 'nbr' => self::NUMBER_OF_NUMBERS);
//        }
//        $cards[] = array('type' => self::VALUE_OF_JOKERS, 'type_arg' => self::VALUE_OF_JOKERS, 'nbr' => self::NUMBER_OF_JOKERS);
//
//        // Create deck, shuffle it and 
//        $this->cards->createCards($cards, 'deck');
//        $this->cards->moveAllCardsInLocation(null, "deck");
//        $this->cards->shuffle('deck');
    }

}
