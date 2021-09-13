<?php
namespace Linko\Managers\Factories;

use Linko\Managers\Core\ManagerFactory;
use Linko\Managers\LogManager;
use Linko\Managers\Core\Manager;
use Linko\Repository\FieldsFactories\LogFieldsFactory;
use Linko\Repository\LogRepository;
use Linko\Serializers\LogSerializer;

/**
 * Factory to create LogManager objects
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class LogManagerFactory implements ManagerFactory{

    public static function create(): Manager {
        //-- REPOSITORY
        $repository = new LogRepository();
        $repository->setFields(LogFieldsFactory::create($repository));

        //-- SERIALIZER
        $serializer = new LogSerializer();
        $repository->setSerializer($serializer);

        //-- MANAGER
        $manager = new LogManager();
        $manager->setRepository($repository)
                ->setSerializer($serializer);

        return $manager;
    }

}
