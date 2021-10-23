<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Linko\States\Traits;

use Linko\Managers\Deck\Deck;
use Linko\Tools\Game\CollectionTakeableIdentifier;
use Linko\Tools\Game\Exceptions\PlayCardException;
use Linko\Tools\Game\PlayCardChecker;
use const ST_RESOLVE_STATE;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait PlayTrait {
    /* -------------------------------------------------------------------------
     *            BEGIN - Play Cards Actions
     * ---------------------------------------------------------------------- */

    public function actionPlayCards($rawCardIds) {
        self::checkAction('playCards');
        
        $playCardChecker = new PlayCardChecker();
        $takeableCollectionIdentifier = new CollectionTakeableIdentifier();

        $cardId = explode(",", $rawCardIds);
        $playerManager = $this->getPlayerManager();
        $cardManager = $this->getCardManager();
        $player = $playerManager->findBy(["id" => self::getActivePlayerId()]);
        $cards = $cardManager->findBy(["id" => $cardId]);

        if ($playCardChecker->check($player, $cards)) {
            $collectionIndex = $cardManager->getNextCollectionIndexFor($player);
            $cardManager->moveCards($cards, Deck::LOCATION_PLAYER_TABLE . "_" . $player->getId(), $collectionIndex);
        } else {
            throw new PlayCardException("Invalid selection try again");
        }
        $collections = $takeableCollectionIdentifier->identify($cards, $player);
        $stateManager = $this->getStateManager();
        $nextState = $stateManager->closeActualState();
        if(!empty($collections)){
            $order = $nextState->getOrder();
            foreach ($collections as $collection){
                
            }
            
            ;die('@TODO');
        }

        
        $this->gamestate->jumpToState(ST_RESOLVE_STATE);
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Display
     * ---------------------------------------------------------------------- */

    public function argPlayCards() {
//        /**
//         * @var PlayerManager
//         */
//        $playerManager = $this->getPlayerManager();
//        $activePlayerId = GlobalVarManager::getVar(GlobalVar::ACTIVE_PLAYER)->getValue();
//        $rawPlayer = $playerManager
//                ->getRepository()
//                ->setDoUnserialization(false)
//                ->getById($activePlayerId);
//
//        return [
//            '_private' => [
//                'active' => $rawPlayer,
//            ],
//        ];
    }

    public function stPlayCards() {
        
    }

}
