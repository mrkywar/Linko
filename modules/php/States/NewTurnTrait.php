<?php

namespace Linko\States;

use Linko;
use Linko\Managers\Logger;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait NewTurnTrait {

    /**
     * stStartOfTurn: called at the beggining of each player turn
     * 
     */
    public function stStartOfTurn() {
        $pid = $this->activeNextPlayer();
        Logger::log("Current Active Player :" . $pid, "NTT");
//        Logger::log($logContent)
//        $logger->log("Find :" . Linko::getInstance()->getCurrentPlayer());
//        $playerManager = Linko::getInstance()->getPlayerManager();
//        var_dump($playerManager);
//        die;
    }

    public function stResolveState() {
//        $globalManger = \Linko\Managers\Factories\GlobalVarManagerFactory::create();
//        $globalManger->
//        $activePlayer = Linko::getInstance()->getCurrentPlayer();
//        var_dump($activePlayer);
//        die;
    }

}
