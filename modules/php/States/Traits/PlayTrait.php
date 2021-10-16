<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Linko\States\Traits;

use Linko\Managers\CardManager;
use Linko\Managers\PlayerManager;
use Linko\Tools\Game\PlayCardChecker;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait PlayTrait {

    public function actionPlayCards($rawCardIds) {
        self::checkAction('playCards');

        $cardId = explode(",", $rawCardIds);
        $playerManager = new PlayerManager(); //$this->getPlayerManager();
        $cardManager = new CardManager(); //$this->getCardManager();
        $player = $playerManager->findBy(["id" => self::getActivePlayerId()]);
        $cards = $cardManager->findBy(["id" => $cardId]);

        PlayCardChecker::check($player, $cards);
        die("checked");

//        Logger::log($player->getName()." play " " card ".$cards[0]->getType());
//        Logger::log("Action Play Card " . $rawCardIds, "PCT-APC");
//        $this->cardIds = explode(",", $rawCardIds);
//
//        $cardManager = $this->getCardManager();
//        $cardRepo = $cardManager->getRepository();
//        $playerId = self::getActivePlayerId();
//        $player = $this->getPlayerManager()
//                ->getRepository()
//                ->setDoUnserialization(true)
//                ->getById($playerId);
//        $cards = $cardRepo
//                ->setDoUnserialization(true)
//                ->getById($this->cardIds);
//
//        $this->collection = CardsToCollectionTransformer::adapt($cards);
//        if (!$this->collection->isPlayableFor($player)) {
//            throw new \BgaUserException(self::_("Invalid Selection"));
//        }
//        $this->collection->setPlayer($player)
//                ->setDestination(Deck::TABLE_NAME . "_" . $playerId)
//                ->setCollectionIndex($cardRepo->getNextCollectionIndex($playerId));
//
//        $cardRepo->moveCardsToLocation(
//                $this->collection->getCards(),
//                $this->collection->getDestination(),
//                $this->collection->getCollectionIndex()
//        );
//
////        $this
//        $this->sendPlayNotification();
//        $this->afterActionPlayCards();
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Play Cards Actions - TOOLS
     * ---------------------------------------------------------------------- */


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
