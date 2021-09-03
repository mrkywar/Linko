<?php
namespace Linko\Managers\Factories;

use Linko\Managers\CardManager;
use Linko\Repository\CardRepository;
use Linko\Repository\FieldsFactories\CardFieldsFactory;
use Linko\Serializers\CardSerializer;

/**
 * Description of PlayerManagerFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class CardManagerFactory {

    public static function create() {
        //-- REPOSITORY
        $repository = new CardRepository();
        $repository->setFields(CardFieldsFactory::create($repository));

        //-- SERIALIZER
        $serializer = new CardSerializer();

        //-- MANAGER
        $manager = new CardManager();
        $manager->setRepository($repository)
                ->setSerializer($serializer);

        return $manager;
    }

}
