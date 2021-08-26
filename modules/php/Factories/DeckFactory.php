<?php

namespace Linko\Factories;

/**
 * Description of DeckFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class DeckFactory {

    CONST TYPES_OF_NUMBERS = 13;
    CONST NUMBER_OF_NUMBERS = 8;
    CONST VALUE_OF_JOKERS = 14;
    CONST NUMBER_OF_JOKERS = 5;

    public static function create() {
        $cards = array();
        for ($number = 1; $number <= self::NUMBER_OF_NUMBERS; ++$number) {
            $cards[] = array('type' => $number, 'type_arg' => $number + 1, 'nbr' => self::NUMBER_OF_NUMBERS);
        }
        $cards[] = array('type' => self::VALUE_OF_JOKERS, 'type_arg' => self::VALUE_OF_JOKERS, 'nbr' => self::NUMBER_OF_JOKERS);

        return $cards;  
    }

    
    
}
