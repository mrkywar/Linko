<?php

namespace Linko\Managers;

use Linko;
use Linko\Managers\Factories\LogManagerFactory;

/**
 * Description of LogManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class LogManager extends Manager {

    public function __construct() {
        self::setInstance($this);
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstract Methods
     * ---------------------------------------------------------------------- */

    protected static function buildManager(): Manager {
        return LogManagerFactory::create();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - init
     * ---------------------------------------------------------------------- */

//    public function init() {
//
//        $activePlayer = Linko::getInstance()->getCurrentPlayer();
//        var_dump($activePlayer);
//        die;
//    }

}
