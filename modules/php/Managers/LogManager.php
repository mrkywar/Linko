<?php

namespace Linko\Managers;

use Linko\Managers\Core\SuperManager;
use Linko\Models\Log;

/**
 * Description of LogManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class LogManager extends SuperManager {

//    private stati

    CONST DEFALUT_CATEGOTY = "debug";

    public function doLog($message, $category = null) {
        if (null === $category) {
            $category = self::DEFALUT_CATEGOTY;
        }

        $log = new Log();
        $log->setCategory($category)
                ->setContent($message);

        $id = $this->create($log);
        $log->setId($id);

        return $log;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstracts Methods 
     * ---------------------------------------------------------------------- */

    protected function initSerializer(): Serializer {
        return new Serializer(Log::class);
    }

}
