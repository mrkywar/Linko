<?php

namespace Linko\Tools\Game\Exceptions;

use Linko\Managers\CardManager;
use Linko\Managers\PlayerManager;
use Linko\Tools\Logger\Logger;

/**
 * Description of EndOfGameChecker
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class EndOfGameChecker {

    /**
     * @var CardManager
     */
    private $cardManager;

    /**
     * @var PlayerManager
     */
    private $playerManager;

    public function __construct() {
        $this->cardManager = new CardManager();
        $this->playerManager = new PlayerManager();
    }

    /**
     * 
     * @return boolean
     */
    public function check() {
        if ($this->isPublicEnd()) {
            Logger::log("End Of Game - By empty Pool & Draw", "EOGC-01");
            return true;
        } else {
            $players = $this->playerManager->findBy();
            foreach ($players as $player) {
                if ($this->isPlayerEnd($player)) {
                    Logger::log("End Of Game - By empty Empty Hand (" . $player->getName() . ')', "EOGC-02");
                    return true;
                }
            }
            return false;
        }
    }

    private function isPublicEnd() {
        $cardInPool = $this->cardManager->getCardInPool();
        $cardInDraw = $this->cardManager->getCardInDraw();
        return (0 === (count($cardInDraw) + count($cardInPool)));
    }

    private function isPlayerEnd(Player $player) {
        $cardInHand = $this->cardManager->getCardInHandByPlayer($player);
        return (0 === count($cardInHand));
    }

}
