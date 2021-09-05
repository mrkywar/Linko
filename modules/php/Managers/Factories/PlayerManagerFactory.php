<?php
namespace Linko\Managers\Factories;

use Linko\Managers\PlayerManager;
use Linko\Repository\FieldsFactories\PlayerFieldsFactory;
use Linko\Repository\PlayerRepository;
use Linko\Serializers\PlayerSerializer;

/**
 * Description of PlayerManagerFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class PlayerManagerFactory {

    public static function create() {
        //-- REPOSITORY
        $repository = new PlayerRepository();
        $repository->setFields(PlayerFieldsFactory::create($repository));

        //-- SERIALIZER
        $serializer = new PlayerSerializer();
        $repository->setSerializer($serializer);

        //-- MANAGER
        $manager = new PlayerManager();
        $manager->setRepository($repository)
                ->setSerializer($serializer);

        return $manager;
    }

}
