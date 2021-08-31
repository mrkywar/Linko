<?php
namespace Linko\Managers\Core;

use Linko\Repository\Core\Repository;
use Linko\Serializers\Core\Serializer;
/**
 * Description of Manager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class Manager {
 
    /**
     * 
     * @var Repository
     */
    private $repository;

    /**
     * 
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
