<?php

namespace Linko\Serializers;

use Linko\Models\Card;

/**
 * Description of CardSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardSerializer extends SuperSerializer {
   
 
    public function getModelClass() {
        return Card::class;
    }

}
