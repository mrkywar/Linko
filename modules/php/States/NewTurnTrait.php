<?php

namespace Linko\States;

use Linko;

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
        $playerManager = Linko::getInstance()->getPlayerManager();
//        var_dump($playerManager);
//        die;
    }

    public function stResolveState() {
        
    }

}
