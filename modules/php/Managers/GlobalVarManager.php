<?php

namespace Linko\Managers;

/**
 * Description of GlobalVarManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class GlobalVarManager extends Manager {

    public function __construct() {
        self::setInstance($this);
    }

}
