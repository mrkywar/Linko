<?php
namespace Linko\Repository;

use Linko\Managers\Deck\Deck;
use Linko\Models\Core\QueryString;
use Linko\Models\Player;
use Linko\Repository\Core\SuperRepository;

/**
 * Description of PlayerRepository
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardRepository extends SuperRepository {

    private CONST TABLE_NAME = "card";
    private CONST FIELDS_PREFIX = "card_";

    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement SuperRepository
     * ---------------------------------------------------------------------- */

    public function getFieldsPrefix() {
        return self::FIELDS_PREFIX;
    }

    public function getTableName() {
        return self::TABLE_NAME;
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Cards 
     * ---------------------------------------------------------------------- */

    public function getCardsInLocation($location, $locationArg = null, $limit = null) {
        $locationField = $this->getFieldByProperty("location");
        $locationArgField = $this->getFieldByProperty("locationArg");

        $qb = $this->getQueryBuilder()
                ->select()
                ->addClause($locationField, $location);
        if (null === $locationArg) {
            $qb->addOrderBy($locationArgField, QueryString::ORDER_DESC);
        } else {
            $qb->addClause($locationArgField, $locationArg);
        }

        if (null !== $limit) {
            $qb->setLimit($limit);
        }

        return $this->execute($qb);
    }

    public function moveCardsToLocation($cards, $location, $locationArg = 0) {
        $locationField = $this->getFieldByProperty("location");
        $locationArgField = $this->getFieldByProperty("locationArg");
        $primary = $this->getPrimaryField();

        $qb = $this->getQueryBuilder()
                ->update()
                ->addSetter($locationField, $location)
                ->addSetter($locationArgField, $locationArg);

        if (is_array($cards)) {
            $ids = [];
            foreach ($cards as $card) {
                $ids[] = $card->getId();
            }
            $qb->addClause($primary, $ids);
        } else {
            $qb->addClause($primary, $cards->getId());
        }

        return $this->execute($qb);
    }
    
    public function getPlayerHand(Player $player) {
        return $this->getCardsInLocation(Deck::HAND_NAME, $player->getId());
    }

}
