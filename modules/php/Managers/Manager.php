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


    /* -------------------------------------------------------------------------
     *                 BEGIN - Instance Management
     * ---------------------------------------------------------------------- */

    abstract public static function getInstance(): Manager;

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
