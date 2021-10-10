<?php

namespace Linko\Managers;

use Linko\Managers\Core\SuperManager;
use Linko\Managers\Deck\Deck;
use Linko\Models\Card;
use Linko\Serializers\Serializer;
use Linko\Tools\DB\DBValueRetriver;
use Linko\Tools\DB\QueryBuilder;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardManager extends SuperManager {

    public function initForNewGame(array $options = array()) {
        $deck = new Deck();

        $this->create($deck->getCards());

        $drawCards = $this->getAll(Deck::DRAW_VISIBLE_CARDS);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Move Methods
     * ---------------------------------------------------------------------- */

    private function moveCard($cards, $destination, $destinationArg = null) {
        $table = $this->getTable($cards);
        $primaries = $this->getPrimaryFields($cards);

        $qb = new QueryBuilder();
        $qb->update()
                ->setTable($table);

        foreach ($primaries as $primary) {
            $qb->addClause($primary, DBValueRetriver::retrive($primary, $cards));
        }
        
        
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstracts Methods 
     * ---------------------------------------------------------------------- */

    protected function initSerializer(): Serializer {
        return new Serializer(Card::class);
    }

}
