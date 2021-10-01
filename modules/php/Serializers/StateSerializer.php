<?php

namespace Linko\Serializers;

use Linko\Models\State;
use Linko\Serializers\Core\SuperSerializer;

/**
 * StateSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class StateSerializer extends SuperSerializer {

    /**
     * give the class of associated model
     * @return type
     */
    public function getModelClass() {
        return State::class;
    }

    
    protected function isArrayForced() {
        return false;
    }
}
