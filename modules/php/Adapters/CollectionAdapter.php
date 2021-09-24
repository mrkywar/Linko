<?php

namespace Linko\Adapters;

use Linko;
use Linko\Models\Card;
use Linko\Serializers\CardSerializer;

/**
 * Description of CollectionAdapter
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class CollectionAdapter {

    /**
     * @var array<Field>
     */
    private static $cardFields;

    /**
     * @var CardSerializer
     */
    private static $cardSerializer;

    public static function adapt($results) {
        $collections = [];
        $cardManger = Linko::getInstance()->getCardManager();
        self::$cardSerializer = $cardManger->getSerializer();
        self::$cardFields = $cardManger->getRepository()->getFields();
        
        if(is_array($results)){
             foreach ($results as $card) {
                self::adaptCard($collections, $card);
            }
        }elseif($results instanceof Card){
            self::adaptCard($collections, $results);
        }
        return $collections;

    }

    private static function adaptCard(&$collections, Card $card) {
        $rawCard = self::$cardSerializer->serialize($card, self::$cardFields);
        $collections[$card->getLocationArg()][] = $rawCard;
    }

}
