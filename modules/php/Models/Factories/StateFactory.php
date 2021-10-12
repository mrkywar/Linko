<?php

namespace Linko\Models\Factories;

use Linko\Models\State;

/**
 * Description of StateFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class StateFactory {

    static public function create($stateType, $playerId, &$order = 1, $params = null) {
        $state = new State();
        $state->setState($stateType)
                ->setOrder($order)
                ->setParams($params)
                ->setPlayerId($playerId);

        $order++;

        return $state;
    }

}
