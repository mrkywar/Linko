<?php

namespace Linko\Managers;

use Linko\Models\Card;
use Linko\Models\Player;
use Linko\Repository\CardRepository;
use Linko\Serializers\CardSerializer;
use Linko\Tools\ArrayCollection;
use Linko\Tools\Notifier;

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
    CONST HAND_NAME = "hand";

    private $deck;
    private $notify;
    /**
     * @var CardRepository
     */
    private $repository;
    /**
     * @var CardSerializer
     */
    private $serializer;

    public function __construct() {
        $this->notify = new Notifier();
        $this->deck= [];
        $this->repository = new CardRepository();
        $this->serializer = $this->repository->getSerializer();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - New Game Initialization
     * ---------------------------------------------------------------------- */

    private function createCard($cardValue, $location = self::DECK_NAME) {
        $card = new Card();
        $card->setLocation($location)
                ->setType($cardValue)
                ->setTypeArg($cardValue);

        return $card;
    }
    
    private function initDeck(){
        for ($number = 1; $number <= self::TYPES_OF_NUMBERS; ++$number) {
            for ($ex = 1; $ex <= self::TYPES_OF_NUMBERS; ++$ex) {
                $this->deck[] = $this->createCard($number);
            }
        }
        for ($jok = 1; $jok <= self::NUMBER_OF_JOKERS; ++$jok){
            $this->deck[]  = $this->createCard(self::VALUE_OF_JOKERS);
        }

        shuffle($this->deck);
        $count = sizeof($this->deck);
        for($order = 0; $order < $count ; ++$order){
            $this->deck[$order]->setLocationArg($count-$order);
        }
        
        $this->repository->create($this->deck);
        
        return $this;
    }

    public function setupNewGame(ArrayCollection $players) {
        $this->initDeck();
        
        
        
        
        
        
    }

//    public function setupNewGame(ArrayCollection $players) {
////        if (null === $this->deckModule) {
////            throw new \feException('No deck module loaded : call setDeckModule'
////                            . '(self::getNew("module.common.deck")) '
////                            . 'before setupNewGame');
////        }
//        $this->deckModule->init("card");
//
//        $cards = array();
//        for ($number = 1; $number <= self::TYPES_OF_NUMBERS; ++$number) {
//            $cards[] = array(
//                'type' => $number,
//                'type_arg' => $number + 1,
//                'nbr' => self::NUMBER_OF_NUMBERS
//            );
//        }
//
//        $this->deckModule->createCards($cards, self::DECK_NAME);
//        $this->deckModule->moveAllCardsInLocation(null, self::DECK_NAME);
//        $this->deckModule->shuffle(self::DECK_NAME);
//
//        return $this->setupFirstCards($players);
//    }
//
//    private function setupFirstCards(ArrayCollection $players) {
//        $this->deckModule->pickCardsForLocation(
//                self::VISIBLE_DRAW,
//                self::DECK_NAME,
//                self::DRAW_NAME
//        );
//        foreach ($players as $player) {
//            $this->setupFirstHand($player);
//        }
//
//        return $this;
//    }
//
//    private function setupFirstHand(Player $player) {
//        $cards = $this->deckModule->pickCards(
//                self::INTIALS_CARD,
//                'deck',
//                $player->getId()
//        );
//
//        $this->notify->newHand($player, $cards);
//
//        return $this;
//    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Cards Finders
     * ---------------------------------------------------------------------- */

    public function getCardsInHand(Player $player) {
        return $this->deckModule->getCardsInLocation(self::HAND_NAME, $player->getId());
    }

    public function getHandsInfos(ArrayCollection $players) {
        $res = [];
        foreach ($players as $player) {
            $res[$player->getId()] = count($this->getCardsInHand($player));
        }
        return $res;
    }

}
