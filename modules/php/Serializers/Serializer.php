<?php
namespace Linko\Serializers;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
interface Serializer {

    public function serialize(\stdClass $object);

    public function unserialize($raw);
}
