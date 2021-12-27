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
        $playerManager = $this->getPlayerManager();
        $cardManager = $this->getCardManager();
        $takeableCollectionIdentifier = new CollectionTakeableIdentifier();
        $stateManager = $this->getStateManager();

        $cardId = explode(",", $rawCardIds);
        $activePlayer = $playerManager->findBy(["id" => self::getActivePlayerId()]);
        $cards = $cardManager->findBy(["id" => $cardId]);

        if ($playCardChecker->check($activePlayer, $cards)) {
            $collectionIndex = $cardManager->getNextCollectionIndexFor($activePlayer);
            $cardManager->moveCards($cards, Deck::LOCATION_PLAYER_TABLE . "_" . $activePlayer->getId(), $collectionIndex);
            
            $collections = $takeableCollectionIdentifier->identify($cards, $activePlayer);
           
            if (!empty($collections)) {
                var_dump($collections);
                die('CFPT');
            } 
        } else {
            throw new PlayCardException("Invalid selection try again");
        }

//        die("WIP");
        $stateManager->closeActualState();
//        $this->gamestate->jumpToState(ST_RESOLVE_STATE);

        $this->gamestate->nextState();
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
