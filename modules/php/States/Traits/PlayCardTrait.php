<?php

namespace Linko\States\Traits;

use Linko\CardsCollection\CardsToCollectionTransformer;
use Linko\CardsCollection\Collection;
use Linko\Managers\Deck\Deck;
use Linko\Managers\GlobalVarManager;
use Linko\Managers\Logger;
use Linko\Managers\PlayerManager;
use Linko\Models\GlobalVar;

/**
 * Description of PlayCardTrait
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait PlayCardTrait {

    private $cardIds;

    /**
     * @var Collection
     */
    private $collection;

    /* -------------------------------------------------------------------------
     *            BEGIN - Play Cards Actions
     * ---------------------------------------------------------------------- */

    public function actionPlayCards($rawCardIds) {
        Logger::log("Action Play Card " . $rawCardIds, "PCT-APC");
        $this->cardIds = explode(",", $rawCardIds);

        $cardManager = $this->getCardManager();
        $cardRepo = $cardManager->getRepository();
        $playerId = self::getActivePlayerId();
        $player = $this->getPlayerManager()
                ->getRepository()
                ->setDoUnserialization(true)
                ->getById($playerId);
        $cards = $cardRepo
                ->setDoUnserialization(true)
                ->getById($this->cardIds);

        $this->collection = CardsToCollectionTransformer::adapt($cards);
        if (!$this->collection->isPlayableFor($player)) {
            throw new \BgaUserException(self::_("Invalid Selection"));
        }
        $this->collection->setPlayer($player)
                ->setDestination(Deck::TABLE_NAME . "_" . $playerId)
                ->setCollectionIndex($cardRepo->getNextCollectionIndex($playerId));

        $cardRepo->moveCardsToLocation(
                $this->collection->getCards(),
                $this->collection->getDestination(),
                $this->collection->getCollectionIndex()
        );

        $this->afterActionPlayCards();
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Play Cards Actions - TOOLS
     * ---------------------------------------------------------------------- */

    private function afterActionPlayCards() {


        self::notifyAllPlayers("playNumber", clienttranslate('${playerName} plays a collection of ${count} card(s) with a value of ${number}'),
                [
                    'playerId' => $this->collection->getPlayer()->getId(),
                    'playerName' => $this->collection->getPlayer()->getName(),
                    'count' => count($this->collection->getCards()),
                    'number' => $this->collection->getNumber(),
                    'collectionIndex' => $this->collection->getCollectionIndex(),
                    'cards' => $this->getCardManager()
                            ->getRepository()
                            ->setDoUnserialization(false)
                            ->getById($this->cardIds)
                ]
        );
        
        $stateManager = $this->getStateManager();
        $newState = $stateManager->closeActualState();
        
        Logger::log("NextState : ".$newState->getState());
        $this->gamestate->jumpToState($newState->getState());

    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Display
     * ---------------------------------------------------------------------- */

    public function argPlayCards() {
        /**
         * @var PlayerManager
         */
        $playerManager = $this->getPlayerManager();
        $activePlayerId = GlobalVarManager::getVar(GlobalVar::ACTIVE_PLAYER)->getValue();
        $rawPlayer = $playerManager
                ->getRepository()
                ->setDoUnserialization(false)
                ->getById($activePlayerId);

        return [
            '_private' => [
                'active' => $rawPlayer,
            ],
        ];
    }

    public function stPlayCards() {
        
    }

}
