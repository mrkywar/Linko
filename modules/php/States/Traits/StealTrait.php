<?php

namespace Linko\States\Traits;

use Linko\Managers\GlobalVarManager;
use Linko\Managers\PlayerManager;
use Linko\Models\GlobalVar;

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

        return [
            '_private' => [
                'active' => $rawPlayer,
            ],
        ];
    }
    
    public function stStealCollection() {
        
    }

}
