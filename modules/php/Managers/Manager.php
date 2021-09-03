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
class Manager {

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var Serializer
     */
    private $serializer;

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
