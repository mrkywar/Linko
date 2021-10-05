<?php

namespace Linko\Models\Core;

/**
 * Description of Model
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class Model extends \stdClass {

    abstract public function getId(): ?int;

    abstract public function setId(int $id);
}
