<?php

namespace Linko\States\Traits;

use Linko\Managers\GlobalVarManager;
use Linko\Models\GlobalVar;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait DrawTrait {
    /* -------------------------------------------------------------------------
     *            BEGIN - Display
     * ---------------------------------------------------------------------- */

    public function stDrawCard() {
        
    }

    public function argDrawCards() {
        $stateManager = $this->getStateManager();
        $playerManager = $this->getPlayerManager();
        $activePlayerId = GlobalVarManager::getVar(GlobalVar::ACTIVE_PLAYER)->getValue();
        $rawPlayer = $playerManager
                ->getRepository()
                ->setDoUnserialization(false)
                ->getById($activePlayerId);

        $actualState = $stateManager->getRepository()
                ->setDoUnserialization(true)
                ->getActualState();
//        var_dump($actualState);die;

        return [
            '_private' => [
                'active' => $rawPlayer,
            ],
            'numberOfCard' => $actualState->getParams()->numberOfCards,
        ];

//"description" => clienttranslate('${actplayer} should draw ${numberOfCard} card(s)'),
    }

}
