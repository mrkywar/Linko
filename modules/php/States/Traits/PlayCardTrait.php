<?php

namespace Linko\States\Traits;

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
    /* -------------------------------------------------------------------------
     *            BEGIN - Play Cards Actions
     * ---------------------------------------------------------------------- */

    public function actionPlayCards($cardIds) {
        Logger::log("Action Play Card " . $cardIds, "PCT-APC");

        $cardManager = $this->getCardManager();
        $cardRepo = $cardManager->getRepository();
        $playerId = self::getActivePlayerId();
        $cards = $cardRepo
                ->setDoUnserialization(true)
                ->getById(explode(",", $cardIds));

        $checkPosition = $this->checkPosition($cards, $playerId);
        $checkNumber = $this->checkNumbers($cards);
        if (!$checkPosition || !$checkNumber) {
            throw new \BgaUserException(self::_("Invalid Selection"));
            //-- TODO KYW : Check if log is needed !
        }
        $destination = Deck::TABLE_NAME . "_" . $playerId;
        $collectionIndex = $cardRepo->getNextCollectionIndex($playerId);
        $cardRepo->moveCardsToLocation($cards, $destination, $collectionIndex);

        $this->afterActionPlayCards();
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Play Cards Actions - TOOLS
     * ---------------------------------------------------------------------- */

    private function checkPosition(array $cards, $playerId) {
        $checkPosition = true;
        foreach ($cards as $card) {
            $checkPosition = $checkPosition &&
                    Deck::HAND_NAME === $card->getLocation() &&
                    $playerId === $card->getLocationArg();
        }
        return $checkPosition;
    }
    
    private function checkNumbers(array $cards) {
        $numbers = null;
        $countNumber = 0;
        $countJoker = 0;
        $checkNumber = true;
        
        foreach ($cards as $card) {
            if (14 === $card->getType()){
                $countJoker ++;
            }elseif(null === $numbers){
                $numbers = $card->getType();
                $countNumber++;
            }elseif($numbers === $card->getType()){
                $countNumber++;
            }else{
                $checkNumber = false;
            }
        }
        
        return $checkNumber && (($countNumber + $countJoker) === count($cards));
        
        
    }

    private function afterActionPlayCards() {
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
