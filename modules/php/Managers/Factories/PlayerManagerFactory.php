<?php

namespace Linko\Managers\Factories;

use Linko\Managers\Core\ManagerFactory;
use Linko\Managers\Core\Manager;
use Linko\Managers\PlayerManager;
use Linko\Repository\FieldsFactories\PlayerFieldsFactory;
use Linko\Repository\PlayerRepository;
use Linko\Serializers\PlayerSerializer;

/**
 * Factory to create PlayerManager objects
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class PlayerManagerFactory implements ManagerFactory {

    public static function create(Manager $manager = null): Manager {
        //-- REPOSITORY
        $repository = new PlayerRepository();
        $repository->setFields(PlayerFieldsFactory::create($repository));

        //-- SERIALIZER
        $serializer = new PlayerSerializer();
        $repository->setSerializer($serializer);

        //-- MANAGER
        if (null === $manager) {
            $manager = new PlayerManager();
        }
        $manager->setRepository($repository)
                ->setSerializer($serializer);

        return $manager;
    }

}
