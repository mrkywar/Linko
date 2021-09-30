<?php

namespace Linko\States\Traits;

use Linko\Managers\GlobalVarManager;
use Linko\Managers\PlayerManager;
use Linko\Models\GlobalVar;
use Linko\Models\State;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait StealTrait {
    /* -------------------------------------------------------------------------
     *            BEGIN - Display
     * ---------------------------------------------------------------------- */

    public function argStealCollection() {
        /**
         * @var PlayerManager
         */
        $playerManager = $this->getPlayerManager();
        $activePlayerId = GlobalVarManager::getVar(GlobalVar::ACTIVE_PLAYER)->getValue();
        $rawPlayer = $playerManager
                ->getRepository()
                ->setDoUnserialization(false)
                ->getById($activePlayerId);

        $stateManager = $this->getStateManager();
        $rawState = $stateManager
                ->getRepository()
                ->setDoUnserialization(false)
                ->getActualState();
        /**
         * @var State
         */
        $actualState = $stateManager
                ->getRepository()
                ->setDoUnserialization(true)
                ->getActualState();

//        var_dump($actualState->getParams());die;

        return [
            '_private' => [
                'active' => $rawPlayer,
            ],
            'tarplayer' => $actualState->getParams()->targetPlayer,
            "actualState" => $rawState
        ];
    }

    public function stStealCollection() {
        
    }
    
    
    public function actionStealCards($action){
        self::checkAction('actionStealCards');
        
        $stateManager = $this->getStateManager();
        $actualState = $stateManager->getRepository()->getActualState();
        
        $cardManager = $this->getCardManager();
        $cardRepo = $cardManager->getRepository();
        
        
//        $cards = 
        
        
        
        var_dump($actualState);die;
    }

}
