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

    public function argPlayCards() {
        /**
         * @var PlayerManager
         */
        $playerManager = $this->getPlayerManager();
        $rawPlayer = $playerManager
                ->getRepository()
                ->setDoUnserialization(false)
                ->getById(GlobalVarManager::getVar(GlobalVar::ACTIVE_PLAYER));

        return [
            '_private' => [
                'active' => $rawPlayer,
            ],
        ];
    }

    public function actionPlayCards($cardIds) {
        Logger::log("Action Play Card " . $cardIds, "PCT-APC");

        $cardManager = $this->getCardManager();
        $playerId = self::getActivePlayerId();
        $cards = $cardManager
                ->getRepository()
                ->setDoUnserialization(true)
                ->getById(explode(",", $cardIds));

        $checkPosition = true;
        foreach ($cards as $card){
            $checkPosition = $checkPosition &&
                    Deck::HAND_NAME === $card->getLocation() &&
                    $playerId === $card->getLocationArg();
        }

        var_dump($checkPosition, $cards);
        die;
    }

    public function stPlayCards() {
        
    }

}
