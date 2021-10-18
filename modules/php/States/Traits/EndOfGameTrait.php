<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Linko\States\Traits;

use Linko\Managers\PlayerManager;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait EndOfGameTrait {

    public function stComupteScore() {
        $playerManager = new PlayerManager();//$this->getPlayerManager();
        $cardManager = $this->getCardManager();

        $players = $playerManager->findBy();

        foreach ($players as &$player) {
            $cardInHand = $cardManager->getCardInHandByPlayer($player);
            $cardPlayed = $cardManager->getCardPlayedByPlayer($player);
            $player->setScore(count($cardPlayed) - count($cardInHand));
            
//            $playerManager->
        }
    }
}
