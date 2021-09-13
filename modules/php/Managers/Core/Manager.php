<?php

namespace Linko\Managers\Core;

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
     * @var array<Manager> contain all used managers instances
     */
    private static $instances = [];

    /* -------------------------------------------------------------------------
     *                 BEGIN - Instance Management
     * ---------------------------------------------------------------------- */

    abstract public function buildInstance(): Manager;

    final static public function getInstance() {
        $instanceClass = get_called_class(); // get PlayerManager / CardManager /... class
        if (!isset(self::$instances[$instanceClass])) {
            $object = new $instanceClass();
            
            self::$instances[$instanceClass] = $object->buildInstance();
        }
        return self::$instances[$instanceClass];
    }

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

}
