<?php
namespace Linko\Managers\Factories;



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

        //-- MANAGER
        $manager = new PlayerManager();
        $manager->setRepository($repository)
                ->setSerializer($serializer);

        return $manager;
    }

}
