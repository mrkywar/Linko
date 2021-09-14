<?php

namespace Linko\States;

use Linko\Managers\GlobalVarManager;
use Linko\Managers\Logger;
use Linko\Models\GlobalVar;

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
        GlobalVarManager::setVar(GlobalVar::ACTIVE_PLAYER, $pid);
        
        
    }

    public function stResolveState() {
//        $globalManger = \Linko\Managers\Factories\GlobalVarManagerFactory::create();
//        $globalManger->
//        $activePlayer = Linko::getInstance()->getCurrentPlayer();
//        var_dump($activePlayer);
//        die;
    }

}
