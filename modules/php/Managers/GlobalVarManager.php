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

    private static $instance;

    public function __construct() {
        self::$instance = $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstract Methods
     * ---------------------------------------------------------------------- */

    public static function getInstance(): Manager {
        if (null === self::$instance) { //constructer haven't be call yet
            self::$instance = GlobalVarManagerFactory::create(); // factory construct !
        }
        return self::$instance;
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
