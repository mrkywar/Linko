<?php

namespace Linko\Serializers;

use Linko\Models\GlobalVar;
use Linko\Serializers\Core\SuperSerializer;

/**
 * GlobalVarSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class GlobalVarSerializer extends SuperSerializer {

    /**
     * give the class of associated model
     * @return type
     */
    public function getModelClass() {
        return GlobalVar::class;
    }

}
