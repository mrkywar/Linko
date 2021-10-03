<?php

namespace Linko\States\Traits;

use Linko\CardsCollection\CardsToCollectionTransformer;
use Linko\CardsCollection\Collection;
use Linko\Managers\Deck\Deck;
use Linko\Managers\GlobalVarManager;
use Linko\Managers\Logger;
use Linko\Managers\PlayerManager;
use Linko\Models\GlobalVar;
use Linko\Models\State;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait StealTrait {
    /* -------------------------------------------------------------------------
     *            BEGIN - Action
     * ---------------------------------------------------------------------- */

    public function actionStealCards($userAction) {
        self::checkAction('actionStealCards');

        $stateManager = $this->getStateManager();
        $actualState = $stateManager->getRepository()->getActualState();

        $cardManager = $this->getCardManager();
        $cardRepo = $cardManager
                ->getRepository();

        $cards = $cardRepo->setDoUnserialization(true)
                ->getCardsInLocation($actualState->getParams()->location, $actualState->getParams()->locationArg);
        $player = $this->getPlayerManager()
                ->getRepository()
                ->setDoUnserialization(true)
                ->getById(self::getActivePlayerId());
        $this->collection = CardsToCollectionTransformer::adapt($cards);
        $this->collection->setPlayer($player);

        switch (strtolower($userAction)) {
            case "steal":
                $this->sendStealNotification();
                $cardRepo->moveCardsToLocation(
                        $cards,
                        Deck::HAND_NAME,
                        $player->getId()
                );

                break;
            case "discard":
                $this->sendDiscardNotification();
                $cardRepo->moveCardsToLocation(
                        $cards,
                        Deck::DISCARD_NAME,
                        $cardRepo->getNextDiscardLocationArg()
                );

                break;
            default :
                throw new \BgaUserException(self::_("Invalid Action"));
        }

        $newState = $stateManager->closeActualState();

        Logger::log("NextState : " . $newState->getState());
        $this->gamestate->jumpToState($newState->getState());
//        $this->gamestate->changeActivePlayer($newState->getPlayerId());
    }

    private function sendStealNotification() {
        $cardRepo = $this->getCardManager()->getRepository();

        $stateManager = $this->getStateManager();
        $actualState = $stateManager->getRepository()->getActualState();

        $cardIds = [];
        foreach ($this->collection->getCards() as $card) {
            $cardIds[] = $card->getId();
        }

        self::notifyAllPlayers("stealCard", clienttranslate('${playerName} steal ${count} cards to ${targetPlayer}'),
                [
                    'playerId' => $this->collection->getPlayer()->getId(),
                    'playerName' => $this->collection->getPlayer()->getName(),
                    'count' => $this->collection->getCountCards(),
                    'number' => $this->collection->getNumber(),
                    'cards' => $cardRepo->setDoUnserialization(false)
                            ->getById($cardIds),
                    'targetPlayer' => $actualState->getParams()->targetPlayer
                ]
        );
    }

    private function sendDiscardNotification() {
        $cardRepo = $this->getCardManager()->getRepository();

        $stateManager = $this->getStateManager();
        $actualState = $stateManager->getRepository()->getActualState();

        $cardIds = [];
        foreach ($this->collection->getCards() as $card) {
            $cardIds[] = $card->getId();
        }

        self::notifyAllPlayers("discardCard", clienttranslate('${playerName} make discard ${count} cards to ${targetPlayer}'),
                [
                    'playerId' => $this->collection->getPlayer()->getId(),
                    'playerName' => $this->collection->getPlayer()->getName(),
                    'count' => $this->collection->getCountCards(),
                    'number' => $this->collection->getNumber(),
                    'cards' => $cardRepo->setDoUnserialization(false)
                            ->getById($cardIds),
                    'targetPlayer' => $actualState->getParams()->targetPlayer
                ]
        );
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Display
     * ---------------------------------------------------------------------- */

    /**
     * @var Collection
     */
    private $collection;

    public function argStealCollection() {
        /**
         * @var PlayerManager
         */
        $playerManager = $this->getPlayerManager();
        $activePlayerId = GlobalVarManager::getVar(GlobalVar::ACTIVE_PLAYER)->getValue();
        $rawPlayer = $playerManager
                ->getRepository()
                ->setDoUnserialization(false)
                ->getById($activePlayerId);

        $stateManager = $this->getStateManager();
        $rawState = $stateManager
                ->getRepository()
                ->setDoUnserialization(false)
                ->getActualState();
        /**
         * @var State
         */
        $actualState = $stateManager
                ->getRepository()
                ->setDoUnserialization(true)
                ->getActualState();

        return [
            '_private' => [
                'active' => $rawPlayer,
            ],
            'tarplayer' => $actualState->getParams()->targetPlayer,
            "actualState" => $rawState
        ];
    }

    public function stStealCollection() {
        
    }

    
    /* -------------------------------------------------------------------------
     *            BEGIN - End Of Steal
     * ---------------------------------------------------------------------- */
    public function stEndOfSteal(){
        $stateManager = $this->getStateManager();
        $actualState = $stateManager->getActualState();

        $this->gamestate->changeActivePlayer($actualState->getPlayerId());
        
        $newState = $stateManager->closeActualState();

        Logger::log("NextState : " . $newState->getState());
        $this->gamestate->jumpToState($newState->getState());
        $this->gamestate->changeActivePlayer($newState->getPlayerId());

    }
}
