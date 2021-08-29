<?php

namespace Linko\Managers;

use Linko\Models\Player;
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

    private $deckModule;
    private $notify;

    public function __construct() {
        $this->notify = new Notifier();
    }

    public function setDeckModule($deckModule) {
        $this->deckModule = $deckModule;
        return $this;
    }

    public function getDeckModule() {
        return $this->deckModule;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - New Game Initialization
     * ---------------------------------------------------------------------- */

    public function setupNewGame(ArrayCollection $players) {
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

        return $this->setupFirstCards($players);
    }

    private function setupFirstCards(ArrayCollection $players) {
        $this->deckModule->pickCardsForLocation(
                self::VISIBLE_DRAW,
                self::DECK_NAME,
                self::DRAW_NAME
        );
        foreach ($players as $player) {
            $this->setupFirstHand($player);
        }

        return $this;
    }

    private function setupFirstHand(Player $player) {
        $cards = $this->deckModule->pickCards(
                self::INTIALS_CARD,
                'deck',
                $player->getId()
        );

        $this->notify->newHand($player, $cards);

        return $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Cards Finders
     * ---------------------------------------------------------------------- */

    public function getCardsInHand(Player $player) {
        return $this->deckModule->getCardsInLocation(self::HAND_NAME, $player->getId());
    }
    
    
    public function getHandsInfos(ArrayCollection $players) {
        $res = [];
        foreach ($players as $player){
            $res[$player->getId()] = count($this->getCardsInHand($player));
        }
        return $res;
    }

}
