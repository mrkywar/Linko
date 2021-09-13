<?php
namespace Linko\Managers\Factories;

use Linko\Managers\Core\ManagerFactory;
use Linko\Managers\GlobalVarManager;
use Linko\Managers\Manager;
use Linko\Repository\FieldsFactories\GlobalVarFieldFactory;
use Linko\Repository\GlobaVarlRepository;
use Linko\Serializers\GlobalVarSerializer;

/**
 * Factory to create GlobalVarManager objects
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class GlobalVarManagerFactory implements ManagerFactory{

    public static function create(): Manager {
        //-- REPOSITORY
        $repository = new GlobalVarRepository();
        $repository->setFields(GlobalVarFieldFactory::create($repository));

        //-- SERIALIZER
        $serializer = new GlobalVarSerializer();
        $repository->setSerializer($serializer);

        //-- MANAGER
        $manager = new GlobalVarManager();
        $manager->setRepository($repository)
                ->setSerializer($serializer);

        return $manager;
    }

}
