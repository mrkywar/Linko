<?php

namespace Linko\Managers;

use Linko\Factories\DeckFactory;
use Linko\Tools\DB_Manager;

/**
 * Description of Cards
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardsManager extends DB_Manager {

    private $deck;

    const LOCATION_DECK = "deck";
    const NAME_OF_DECK = "deck";

    //-- Abstract definitions (required by DB_Manager)
    protected function getPrimary() {
        return 'card_id';
    }

    protected function getTableName() {
        return 'card';
    }

    public function __construct() {
        parent::__construct();
        $this->deck = self::getNew("module.common.deck");
        $this->deck->init("card");
    }

    public function setupNewGame() {
        $cards = DeckFactory::create();

        $this->deck->createCards($cards, self::NAME_OF_DECK);
        $this->deck->moveAllCardsInLocation(null, self::LOCATION_DECK);
        $this->deck->shuffle(self::NAME_OF_DECK);

        return $this;
    }

    public function getDeck() {
        return $this->deck;
    }

    /**
     * 
     * @param string $location
     * @param mixed $arg
     * @return type
     */
    public function getCardInLocation(string $location = self::LOCATION_DECK, mixed $arg = null) {
        return $this->deck->getInLocation([$location,$arg]);
    }

}
