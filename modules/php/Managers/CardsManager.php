<?php

namespace Linko\Managers;

use Linko;
use Linko\Factories\DeckFactory;
use Linko\Models\Player;
use Linko\Tools\DB_Manager;

/**
 * Description of Cards
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardsManager extends DB_Manager {

    private $deck;

    const LOCATION_DECK = "deck";
    const LOCATION_HAND = "hand";
    const LOCATION_IN_GAME = "playertablecard_";
    const LOCATION_VISIBLE_DRAW = "draw";
    const NAME_OF_DECK = "deck";

    //-- Abstract definitions (required by DB_Manager)
    protected function getPrimary() {
        return 'card_id';
    }

    protected function getTableName() {
        return 'card';
    }

    public function __construct() {
        $this->deck = Linko::getDeckModule();
        $this->deck->init("card");
    }

    public function setupNewGame() {
        $cards = DeckFactory::create();

        $this->deck->createCards($cards, self::NAME_OF_DECK);
        $this->deck->moveAllCardsInLocation(null, self::LOCATION_DECK);
        $this->deck->shuffle(self::NAME_OF_DECK);

        return $this;
    }

    public function pickCardsFor($playerId, $numberOfCards = 1, $location = self::LOCATION_DECK) {
        return $this->deck->pickCards($numberOfCards, $location, $playerId);
    }

    /* --------------------------------
     *  BEGIN cards localisation methods
     * --------------------------------
     */

    /**
     * 
     * 
     * @param string $location
     * @param mixed $arg
     * @return type
     */
    public function getCardsInLocation(string $location, mixed $arg = null) {
        return $this->deck->getCardsInLocation([$location, $arg]);
    }

    /**
     * Get Hand is a shortcut for get cards in a player hand
     * 
     * @param Player played : the player who whant his hand
     */
    public function getHand(Player $player) {
        return $this->getCardsInLocation(self::LOCATION_HAND, $player->getId());
    }

    /**
     * Get cards group by collection played by a player
     * 
     * @param Player played : the player who whant his hand
     */
    public function getPlayedCollections(Player $player) {

        $result = array();
        $raw = $this->getCardsInLocation(self::LOCATION_IN_GAME . $player->getId());

        foreach ($raw as $playedCard) {
            $result[$playedCard['location_arg']][] = $playedCard;
        }

        return $result;
    }

    /**
     * GetDeck is a shortcut for get cards in deck
     */
    public function getDeck() {
        return $this->getCardsInLocation(self::LOCATION_DECK);
    }

    /**
     * getVisibleDraw is a shortcut for get visible card in the draw
     */
    public function getVisibleDraw() {
        return $this->getCardsInLocation(self::LOCATION_VISIBLE_DRAW);
    }

    /* --------------------------------
     *  END cards localisation methods
     * --------------------------------
     */
}
