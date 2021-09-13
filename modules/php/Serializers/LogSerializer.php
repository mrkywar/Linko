<?php

namespace Linko\Serializers;

use Linko\Models\Log;
use Linko\Serializers\Core\SuperSerializer;

/**
 * LogSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class LogSerializer extends SuperSerializer {

    /**
     * give the class of associated model
     * @return type
     */
    public function getModelClass() {
        return Log::class;
    }

}
