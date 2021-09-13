<?php

namespace Linko\Managers;

use Linko\Managers\Factories\LogManagerFactory;
use Linko\Models\Log;

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

    public function log($logContent, $logCategory=null){
        $log = new Log();
        if(null !== $logCategory){
            $log->setCategory($logCategory);
        }
        $log->setContent($logContent);
        
        $logId = $this->getRepository()->create($log);
        
        var_dump($logId);
        
        
    }
}
