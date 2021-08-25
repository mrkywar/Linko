<?php

namespace Linko\Models;

/**
 * Description of Card
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Card implements Model {

    private $id;
    private $type;
    private $typeArg;
    private $location;
    private $locationArg;
    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }

    public function getTypeArg() {
        return $this->typeArg;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getLocationArg() {
        return $this->locationArg;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setTypeArg($typeArg) {
        $this->typeArg = $typeArg;
        return $this;
    }

    public function setLocation($location) {
        $this->location = $location;
        return $this;
    }

    public function setLocationArg($locationArg) {
        $this->locationArg = $locationArg;
        return $this;
    }


}
