<?php

namespace Linko\Serializers;

use Linko\Models\Model;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
interface Serializer {

    public function serialize(Model $object, array $fields, $prefix = "");

    public function unserialize($raw);

}
