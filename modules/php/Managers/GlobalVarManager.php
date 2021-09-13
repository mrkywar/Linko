<?php

namespace Linko\Managers;

use Linko;
use Linko\Managers\Core\Manager;
use Linko\Managers\Factories\GlobalVarManagerFactory;

/**
 * Description of GlobalVarManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class GlobalVarManager extends Manager{

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstract Methods
     * ---------------------------------------------------------------------- */

    public function buildInstance(): Manager {
        return GlobalVarManagerFactory::create($this); // factory construct !
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - init
     * ---------------------------------------------------------------------- */

    public function init() {

        $activePlayer = Linko::getInstance()->getCurrentPlayer();
        var_dump($activePlayer);
        die;
    }

}
