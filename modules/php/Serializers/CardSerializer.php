<?php

namespace Linko\Serializers;

use Linko\Models\Card;
use Linko\Serializers\Core\SuperSerializer;

/**
 * CardSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardSerializer extends SuperSerializer {

    /**
     * give the class of associated model
     * @return type
     */
    public function getModelClass() {
        return Card::class;
    }

}
