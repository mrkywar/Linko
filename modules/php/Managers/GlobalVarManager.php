<?php

namespace Linko\Managers;

use Linko\Managers\Core\Manager;
use Linko\Managers\Factories\GlobalVarManagerFactory;
use Linko\Models\GlobalVar;

/**
 * Description of GlobalVarManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class GlobalVarManager extends Manager {
    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstract Methods
     * ---------------------------------------------------------------------- */

    public function buildInstance(): Manager {
        return GlobalVarManagerFactory::create($this); // factory construct !
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - setter
     * ---------------------------------------------------------------------- */

    public function createOrUpdate($globalId, $value) {
        $globalVar = $this->getRepository()
                ->getById($globalId);

        if (null === $globalVar) {
            $globalVar = new GlobalVar();
            $globalVar->setId($globalId)
                    ->setValue($value);
            
            $this->getRepository()->create($globalVar);
        }else{
            $globalVar->setValue($value);
            
            $this->getRepository()->update($globalVar);
        }

        return $globalVar;
    }

    public static function setVar($globalId, $value) {
        self::getInstance()->createOrUpdate($globalId, $value);
    }

}
