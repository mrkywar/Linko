<?php

namespace Linko\Managers\Factories;

use Linko\Managers\Core\ManagerFactory;
use Linko\Managers\Logger;
use Linko\Managers\Core\Manager;
use Linko\Repository\FieldsFactories\LogFieldsFactory;
use Linko\Repository\LogRepository;
use Linko\Serializers\LogSerializer;

/**
 * Factory to create Logger (aka LogManager) objects
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class LoggerFactory implements ManagerFactory {

    public static function create(Manager $manager = null): Manager {
        //-- REPOSITORY
        $repository = new LogRepository();
        $repository->setFields(LogFieldsFactory::create($repository));

        //-- SERIALIZER
        $serializer = new LogSerializer();
        $repository->setSerializer($serializer);

        //-- MANAGER
        if (null === $manager) {
            $manager = new Logger();
        }
        $manager->setRepository($repository)
                ->setSerializer($serializer);

        return $manager;
    }

}
