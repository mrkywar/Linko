<?php

namespace Linko\Serializers\Core;

use Linko\Models\Core\Model;

/**
 * Allow transform Model <--> Array
 * 
 * @author Mr_Kywar mr_kywar@gmail.com
 */
interface Serializer {

    public function serialize(Model $object, array $fields);

    public function unserialize($rawDatas, array $fields);

}
