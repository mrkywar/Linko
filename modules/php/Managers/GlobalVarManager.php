<?php

namespace Linko\Managers;

use Linko;
use Linko\Managers\Factories\GlobalVarManagerFactory;

/**
 * Description of GlobalVarManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class GlobalVarManager extends Manager {

    public function __construct() {
        self::setInstance($this);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstract Methods
     * ---------------------------------------------------------------------- */

    protected static function buildManager(): Manager {
        return GlobalVarManagerFactory::create();
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
