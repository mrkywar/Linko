<?php

namespace Linko\Serializers;

use Linko\Models\Model;
use Linko\Models\Player;
use Linko\Repository\PlayerRepository;
use ReflectionClass;
use ReflectionMethod;

/**
 * Description of PlayerSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerSerializer extends SuperSerializer {
    
    public function getModelClass() {
        return Player::class;
    }

    public function initModel(): Model {
        
    }

}
