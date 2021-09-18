<?php

namespace Linko\States\Traits;

use Linko\Managers\Logger;
use Linko\Models\State;

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
        Logger::log("Begin Start of Turn");
        $players = $this->getPlayerManager()->getRepository()->getAll();
        $stateRepo = $this->getStateManager()->getRepository();
        $lastState = $stateRepo->getLastState();
        
        if (null === $lastState) {
            Logger::log("NO STATE ..??");
            $order = 1;
        } else {
            Logger::log("STATE Order : ".$lastState->getOrder());
            $order = $lastState->getOrder() + 1;
        }

        $newStates = [];
        foreach ($players as $player) {
            Logger::log("Pass Player :" . $player->getId());

            $state = new State();
            $state->setOrder($order)
                    ->setPlayerId($player->getId())
                    ->setState(ST_PLAYER_PLAY_NUMBER);

            $order++;
            $newStates[] = $state;
        }

        $nextTurn = new State();
        $nextTurn->setOrder($order)
                ->setState(ST_END_OF_TURN);

        $newStates[] = $nextTurn;

        $stateRepo->create($newStates);
    }

    public function stResolveState() {
//        $globalManger = \Linko\Managers\Factories\GlobalVarManagerFactory::create();
//        $globalManger->
//        $activePlayer = Linko::getInstance()->getCurrentPlayer();
//        var_dump($activePlayer);
//        die;
    }

}
