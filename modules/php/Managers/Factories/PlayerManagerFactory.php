<?php
namespace Linko\Managers;

use Linko\Managers\Core\ManagerException;
use Linko\Managers\PlayerManager;
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
        $repository->setFields(PlayerManagerFactory::create());
        
        //-- SERIALIZER
        $serializer = new PlayerSerializer();
        
        //-- MANAGER
        $manager = new PlayerManager();
        $manager->setRepository($repository)
                ->setSerializer($serializer);


        return $manager;
    }
    
}