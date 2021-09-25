<?php

namespace Linko\States\Traits;

use Linko\Managers\Deck\Deck;
use Linko\Managers\GlobalVarManager;
use Linko\Managers\Logger;
use Linko\Managers\PlayerManager;
use Linko\Models\Card;
use Linko\Models\GlobalVar;

/**
 * Description of PlayCardTrait
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait PlayCardTrait {
    /* -------------------------------------------------------------------------
     *            BEGIN - Play Cards Actions
     * ---------------------------------------------------------------------- */

    public function actionPlayCards($rawCardIds) {
        Logger::log("Action Play Card " . $rawCardIds, "PCT-APC");
        $cardIds = explode(",", $rawCardIds);

        $cardManager = $this->getCardManager();
        $cardRepo = $cardManager->getRepository();
        $playerId = self::getActivePlayerId();
        $cards = $cardRepo
                ->setDoUnserialization(true)
                ->getById($cardIds);

        $checkPosition = $this->checkPosition($cards, $playerId);
        $checkNumber = $this->checkNumbers($cards);
        if (!$checkPosition || !$checkNumber) {
            throw new \BgaUserException(self::_("Invalid Selection"));
            //-- TODO KYW : Check if log is needed !
        }
        $destination = Deck::TABLE_NAME . "_" . $playerId;
        $collectionIndex = $cardRepo->getNextCollectionIndex($playerId);
        $cardRepo->moveCardsToLocation($cards, $destination, $collectionIndex);

        $this->afterActionPlayCards($cardIds, $cards);
        if (1 === sizeof($cardIds)) {
            $number = $cards->getType();
        }else{
            $number = $cards[0]->getType();
        }

        self::notifyAllPlayers("playNumber", clienttranslate('${playerName} plays a collection of ${count} card(s) with a value of ${number}'),
                [
                    'playerId' => self::getActivePlayerId(),
                    'playerName' => self::getActivePlayerName(),
                    'count' => count($cardIds),
                    'number' => $number,
                    'collectionIndex' => $collectionIndex,
                    'destination' => $destination,
                    'cardIds' => $cardIds
                ]
        );
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Play Cards Actions - TOOLS
     * ---------------------------------------------------------------------- */

    private function checkPosition($cards, $playerId) {
        $checkPosition = true;
        if (is_array($cards)) {
            foreach ($cards as $card) {
                $checkPosition = $checkPosition &&
                        Deck::HAND_NAME === $card->getLocation() &&
                        $playerId === $card->getLocationArg();
            }
        } else {
            $checkPosition = $checkPosition &&
                    Deck::HAND_NAME === $cards->getLocation() &&
                    $playerId === $cards->getLocationArg();
        }
        return $checkPosition;
    }

    private function checkNumbers($cards) {
        $numbers = null;
        $countNumber = 0;
        $countJoker = 0;
        $checkNumber = true;
        if ($cards instanceof Card) {
            return $checkNumber; // no collection only one card
        }
        foreach ($cards as $card) {
            if (14 === $card->getType()) {
                $countJoker++;
            } elseif (null === $numbers) {
                $numbers = $card->getType();
                $countNumber++;
            } elseif ($numbers === $card->getType()) {
                $countNumber++;
            } else {
                $checkNumber = false;
            }
        }

        return $checkNumber && (($countNumber + $countJoker) === count($cards));
    }

    private function afterActionPlayCards(array $cardsId, $cards) {
        $stateManager = $this->getStateManager();
        $newState = $stateManager->closeActualState();

        Logger::log("NextState : " . $newState->getState());

        

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
