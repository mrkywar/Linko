<?php

namespace Linko\Managers;

use Linko\Models\Card;
use Linko\Models\Player;
use Linko\Repository\CardRepository;
use Linko\Serializers\CardSerializer;
use Linko\Tools\ArrayCollection;
use Linko\Tools\Notifier;
use Linko\Tools\QueryBuilder;

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
        $this->deck = [];
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

    private function initDeck() {
        for ($number = 1; $number <= self::TYPES_OF_NUMBERS; ++$number) {
            for ($ex = 1; $ex <= self::TYPES_OF_NUMBERS; ++$ex) {
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

        $this->repository->create($this->deck);

        return $this;
    }
    
    

//    private function drawCard(Player $player, $nbCards = 1, $from = self::DECK_NAME) {
//        $locationArg = $this->repository->getFieldsByProperty("locationArg");
//        $location = $this->repository->getFieldsByProperty("locationArg");
//
//        $cards = $this->repository
//                ->getQueryBuilder()
//                ->preapareSelect()
//                ->addWhere($location, $from)
//                ->addOrderBy($locationArg, QueryBuilder::ORDER_DESC)
//                ->execute();
//
//        if ($nbCards !== count($cards)) {
//            throw new \feException("Not enoth card aviable in $from");
//        }
//        
//        foreach ($cards as &$card){
//            $card->setLocation(self::HAND_NAME)
//                ->setLocationArg($player->getId());
//        }
//        
//        var_dump($cards);die;
//        
//        
//    }

    public function setupNewGame(ArrayCollection $players) {
        $this->initDeck();
        $this->deck = $this->repository->getAllInLocation(self::DECK_NAME);
        
        
        //
        for($i = 0; $i < self::VISIBLE_DRAW; $i++){
            
        }
        
        
        
        echo '<pre>';
        var_dump($this->deck);die;
        
    }

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
        return $this->repository->getAllInLocation(self::HAND_NAME, $player->getId());
    }

    public function getHandsInfos(ArrayCollection $players) {
        $res = [];
        foreach ($players as $player) {
            $res[$player->getId()] = count($this->getCardsInHand($player));
        }
        return $res;
    }
    
    
    /* -------------------------------------------------------------------------
     *                  BEGIN - Move Cards
     * ---------------------------------------------------------------------- */
    
    public function moveCard(Card $card, $destination, $destinationArg){
        $card->setLocation($destination)
                ->setLocationArg($destinationArg);
        
        
    }

}
