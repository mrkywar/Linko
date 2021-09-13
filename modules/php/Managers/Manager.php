<?php

namespace Linko\Managers;

use Linko\Repository\Core\Repository;
use Linko\Serializers\Core\Serializer;

/**
 * Description of Manager abstract class for Model Management (Player/Card for
 * Exemple )
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class Manager {

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var Serializer
     */
    private $serializer;
    
    
    /**
     * @var Manager
     */
    private static $instance;
    
    /* -------------------------------------------------------------------------
     *                 BEGIN - Abstract Methods 
     * ---------------------------------------------------------------------- */
    
    abstract protected static function buildManager(): Manager;
    
//    abstract protected function init(ManagerFactory)

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getRepository(): Repository {
        return $this->repository;
    }

    public function getSerializer(): Serializer {
        return $this->serializer;
    }

    public function setRepository(Repository $repository) {
        $this->repository = $repository;
        return $this;
    }

    public function setSerializer(Serializer $serializer) {
        $this->serializer = $serializer;
        return $this;
    }
    
    public static function getInstance(): Manager {
        if(null === self::$instance){
            self::$instance = self::buildManager();
        }
        return self::$instance;
    }

    public static function setInstance(Manager $instance) {
        self::$instance = $instance;
    }



}
