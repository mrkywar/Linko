<?php

namespace Linko\CardsCollection;

use Linko\Managers\Deck\Deck;
use Linko\Managers\Logger;
use Linko\Models\Card;
use Linko\Models\Player;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Collection {

    /**
     * @var int
     */
    private $number;

    /**
     * @var array<Card>
     */
    private $cards;

    /**
     * @var string
     */
    private $destination;

    /**
     * @var int
     */
    private $collectionIndex;

    /**
     * @var Player
     */
    private $player;

    /**
     * @var Player
     */
    private $targetedPlayer;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Adder & Retriver
     * ---------------------------------------------------------------------- */

    public function addCard(Card $card) {
        $this->cards[] = $card;
        return $this;
    }

    public function getCardAt(int $index = 0) {
        if (isset($this->cards[$index])) {
            return $this->cards[$index];
        }
        return;
    }

    public function getCountCards() {
        return count($this->getCards());
    }

    /* -------------------------------------------------------------------------
     *                BEGIN - isPlayableFor Player Check
     * ---------------------------------------------------------------------- */

    public function isPlayableFor(Player $player) {
        return $this->checkNumbers() && $this->checkPosition($player);
    }

    private function checkPosition(Player $player) {
        $checkPosition = true;

        foreach ($this->getCards() as $card) {
            $checkPosition = $checkPosition &&
                    Deck::HAND_NAME === $card->getLocation() &&
                    $player->getId() === $card->getLocationArg();
        }

        if (!$checkPosition) {
            /**
             * @TODO Check if logger needed
             */
            Logger::log("Check position fail");
        }
        return $checkPosition;
    }

    private function checkNumbers() {
        $numbers = null;
        $countNumber = 0;
        $countJoker = 0;
        $checkNumber = true;
        foreach ($this->getCards() as $card) {
            if ("14" === $card->getType()) {
                $countJoker++;
            } elseif (null === $numbers) {
                $numbers = $card->getType();
                $countNumber++;
            } elseif ($numbers === $card->getType()) {
                $countNumber++;
            } else {
                $checkNumber = false;
            }
        }
        $checkNumber = $checkNumber && (($countNumber + $countJoker) === count($this->getCards()));

        if (!$checkNumber) {
            /**
             * @TODO Check if logger needed
             */
            Logger::log("Check Number fail");
        }

        return $checkNumber;
    }

    /* -------------------------------------------------------------------------
     *                BEGIN - isTakeableFor Collection Check
     * ---------------------------------------------------------------------- */

    public function isTakeableFor(Collection $askCollection) {
        return(
                $this->getNumber() < $askCollection->getNumber() &&
                $this->getCountCards() === $askCollection->getCountCards()
                );
    }

    /* -------------------------------------------------------------------------
     *                BEGIN - number determine
     * ---------------------------------------------------------------------- */

    private function initNumber() {
        foreach ($this->getCards() as $card) {
            if (null === $this->number || intval($card->getType()) < $this->number) {
                $this->number = intval($card->getType());
            }
        }
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    /**
     * 
     * @return int
     */
    public function getNumber(): int {
        if (null === $this->number) {
            $this->initNumber();
        }
        return $this->number;
    }

    /**
     * 
     * @return type
     */
    public function getCards() {
        return $this->cards;
    }

    /**
     * 
     * @param int $number
     * @return $this
     */
    public function setNumber(int $number) {
        $this->number = $number;
        return $this;
    }

    /**
     * 
     * @param type $cards
     * @return $this
     */
    public function setCards($cards) {
        $this->cards = $cards;
        return $this;
    }

    public function getDestination(): string {
        return $this->destination;
    }

    /**
     * 
     * @param string $destination
     * @return $this
     */
    public function setDestination(string $destination) {
        $this->destination = $destination;
        return $this;
    }

    /**
     * 
     * @return int
     */
    public function getCollectionIndex(): int {
        if (null === $this->collectionIndex) {
            $this->collectionIndex = $this->getCardAt()->getLocationArg();
        }
        return $this->collectionIndex;
    }

    /**
     * 
     * @param int $collectionIndex
     * @return $this
     */
    public function setCollectionIndex(int $collectionIndex) {
        $this->collectionIndex = $collectionIndex;
        return $this;
    }

    /**
     * 
     * @return Player
     */
    public function getPlayer(): Player {
        return $this->player;
    }

    /**
     * 
     * @return Player
     */
    public function getTargetedPlayer(): Player {
        return $this->targetedPlayer;
    }

    /**
     * 
     * @param Player $player
     * @return $this
     */
    public function setPlayer(Player $player) {
        $this->player = $player;
        return $this;
    }

    /**
     * 
     * @param Player $targetedPlayer
     * @return $this
     */
    public function setTargetedPlayer(Player $targetedPlayer) {
        $this->targetedPlayer = $targetedPlayer;
        return $this;
    }

}
