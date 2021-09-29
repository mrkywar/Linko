<?php

namespace Linko\Models\Factories;

use DateTime;
use Linko\Models\State;

/**
 * Description of StateFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class StateFactory {

    public static function create(int $stateType, int &$stateOrder = 1, int $playerId = null, array $params = array()) {
        $state = new State();

        $state->setCreatedDate(new DateTime())
                ->setOrder($stateOrder)
                ->setPlayerId($playerId)
                ->setState($stateType)
                ->setParams($params);

        $stateOrder++;

        return $state;
    }

}
