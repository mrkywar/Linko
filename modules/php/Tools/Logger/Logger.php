<?php

namespace Linko\Tools\Logger;

use Linko\Managers\LogManager;

/**
 * Description of Logger
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class Logger {

    /**
     * @var LogManager
     */
    static private $manager;

    static private function getManager(): LogManager {
        if (null === self::$manager) {
            self::$manager = new LogManager();
        }
        return self::$manager;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Logger Itself
     * ---------------------------------------------------------------------- */

    static public function log($message, $category = null) {
        return self::getManager()->doLog($message, $category);
    }

}
