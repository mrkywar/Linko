<?php

namespace Linko\Serializers;

use Linko\Models\Player;
use Linko\Serializers\Core\SuperSerializer;

/**
 * Description of PlayerSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardSerializer extends SuperSerializer {
    
    public function getModelClass() {
        return Card::class;
    }

    
}
