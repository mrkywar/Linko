<?php

namespace Linko\Serializers\Core;

use Linko\Models\Model;
use Linko\Tools\ArrayCollection;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
interface Serializer {

    public function serialize(Model $object, ArrayCollection $fields);

    public function unserialize($raw);

}
