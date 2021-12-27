<?php

namespace Linko\Managers;

use Linko\Managers\Core\SuperManager;
use Linko\Managers\Deck\Deck;
use Linko\Models\Card;
use Linko\Models\Player;
use Linko\Serializers\Serializer;
use Linko\Tools\DB\DBValueRetriver;
use Linko\Tools\DB\Fields\DBFieldsRetriver;
use Linko\Tools\DB\QueryBuilder;
use Linko\Tools\DB\QueryString;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardManager extends SuperManager {
    
    public function __construct() {
        $this->getSerializer()->setIsForcedArray(true);
    }

    public function initNewGame($players, array $options = []) {
        $deck = new Deck();

        $this->create($deck->getCards());

        $drawCards = $this->drawCards(Deck::DRAW_VISIBLE_CARDS);
        $this->moveCards($drawCards, Deck::LOCATION_POOL);

        foreach (array_keys($players) as $playerId) {
            $playerCards = $this->drawCards(Deck::DECK_INITIAL_HAND);
            $this->moveCards($playerCards, Deck::LOCATION_HAND, $playerId);
        }
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Get Card In Location
     * ---------------------------------------------------------------------- */

    private function prepareGetCardInLocation($location, $locationArg = null, $limit = null) {
        $clauses = ["location" => $location];
        if (null !== $locationArg) {
            $clauses["locationArg"] = $locationArg;
        }

        return $this->prepareFindBy($clauses, $limit);
    }

    private function getCardInLocationOrderByType($location, $locationArg = null, $limit = null) {
        $typeField = $this->getFieldByProperty("type");

        $qb = $this->prepareGetCardInLocation($location, $locationArg, $limit)
                ->addOrderBy($typeField, QueryString::ORDER_ASC);

        $rawResults = $this->execute($qb);

        return $this->getSerializer()->unserialize($rawResults);
    }

    private function getCardInLocation($location, $locationArg = null, $limit = null) {
        $qb = $this->prepareGetCardInLocation($location, $locationArg, $limit);

        $rawResults = $this->execute($qb);

        return $this->getSerializer()->unserialize($rawResults);
    }

    public function drawCards($amount = 1) {
        return $this->getCardInLocation(Deck::LOCATION_DRAW, null, $amount);
    }

    public function getCardInDraw() {
        return $this->getCardInLocation(Deck::LOCATION_DRAW);
    }

    public function getCardInDiscard() {
        return $this->getCardInLocation(Deck::LOCATION_DISCARD);
    }

    public function getCardPlayedByPlayer(Player $player) {
        return $this->getCardInLocationOrderByType(Deck::LOCATION_PLAYER_TABLE . "_" . $player->getId());
    }

    public function getCardInPool() {
        return $this->getCardInLocationOrderByType(Deck::LOCATION_POOL);
    }

    public function getCardInHandByPlayer(Player $player) {
        return $this->getCardInLocationOrderByType(Deck::LOCATION_HAND, $player->getId());
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Move Methods
     * ---------------------------------------------------------------------- */

    public function moveCards($cards, $destination, $destinationArg = null) {
        $qb = $this->prepareUpdate($cards);

        $fieldLoc = DBFieldsRetriver::retriveFieldByPropertyName("location", $cards);
        $qb->addSetter($fieldLoc, $destination);

        if (null !== $destinationArg) {
            $fieldArg = DBFieldsRetriver::retriveFieldByPropertyName("locationArg", $cards);
            $qb->addSetter($fieldArg, $destinationArg);
        }

        $this->execute($qb);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Collection Methods
     * ---------------------------------------------------------------------- */

    public function getNextCollectionIndexFor(Player $player) {
        $qb = new QueryBuilder();
        $table = $this->getTable();

        $qb->select()
                ->setTable($table)
                ->addFunctionField("max", $this->getFieldByProperty("locationArg"))
                ->addClause($this->getFieldByProperty("location"), Deck::LOCATION_PLAYER_TABLE . "_" . $player->getId())
        ;

        $rawResults = $this->execute($qb);
        $card = $this->getSerializer()->setIsForcedArray(false)->unserialize($rawResults);
        $this->getSerializer()->setIsForcedArray(true);

        return intval($card->getLocationArg()) + 1;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstracts Methods 
     * ---------------------------------------------------------------------- */

    protected function initSerializer(): Serializer {
        return new Serializer(Card::class);
    }

}
