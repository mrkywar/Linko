<?php

namespace Linko\Managers\Factories;

use Linko\Managers\Core\Manager;
use Linko\Managers\Core\ManagerFactory;
use Linko\Managers\StateManager;
use Linko\Repository\FieldsFactories\StateFieldsFactory;
use Linko\Repository\StateRepository;
use Linko\Serializers\StateSerializer;

/**
 * Factory to create CardManager objects
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class StateManagerFactory implements ManagerFactory {

    public static function create(Manager $manager = null): Manager {
        //-- REPOSITORY
        $repository = new StateRepository();
        $repository->setFields(StateFieldsFactory::create($repository));

        //-- SERIALIZER
        $serializer = new StateSerializer();
        $repository->setSerializer($serializer);

        //-- MANAGER
        if(null === $manager){
            $manager = new StateManager();
        } 
        $manager->setRepository($repository)
                ->setSerializer($serializer);

        return $manager;
    }

}
