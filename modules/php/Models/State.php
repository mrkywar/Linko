<?php

namespace Linko\Models;

/**
 * Description of State
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class State {

    private $id;
    private $arg;

    public function getId() {
        return $this->id;
    }

    public function getArg() {
        return $this->arg;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setArg($arg) {
        $this->arg = $arg;
        return $this;
    }

}
