<?php

namespace Linko\Adapters;

use Linko\Models\Card;

/**
 * Description of CollectionAdapter
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class CollectionAdapter {

    public static function adapt($results) {
        $collections = [];
        if (1===1 || null === $results || empty($results)) { // tempory hack !
            return $collections;
        } else {
            foreach ($results as $card) {      
                $collections[$card["card_location_arg"]][] = $card;
            }

            return $collections;
        }
    }

}
