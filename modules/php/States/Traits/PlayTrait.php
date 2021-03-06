<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Linko\States\Traits;

use Linko\Managers\CardManager;
use Linko\Managers\Deck\Deck;
use Linko\Managers\PlayerManager;
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

        $cardId = explode(",", $rawCardIds);
        $playerManager = $this->getPlayerManager();
        $cardManager = $this->getCardManager();
        $player = $playerManager->findBy(["id" => self::getActivePlayerId()]);
        $cards = $cardManager->findBy(["id" => $cardId]);

        if ($playCardChecker->check($player, $cards)) {
            $collectionIndex = $cardManager->getNextCollectionIndexFor($player);
            var_dump($collectionIndex);die;
            $cardManager->moveCards($cards, Deck::LOCATION_PLAYER_TABLE . "_" . $player->getId(), $collectionIndex);
        } else {
            throw new PlayCardException("Invalid selection try again");
        }

//        var_dump($this->gamestate);die;

        $this->getStateManager()->closeActualState();
        $this->gamestate->jumpToState(ST_RESOLVE_STATE);

//        $this->gamestate->nextState();
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
