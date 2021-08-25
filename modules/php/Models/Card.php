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
    private $type_arg;
    private $location;
    private $location_arg;

    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }

    public function getType_arg() {
        return $this->type_arg;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getLocation_arg() {
        return $this->location_arg;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setType_arg($type_arg) {
        $this->type_arg = $type_arg;
        return $this;
    }

    public function setLocation($location) {
        $this->location = $location;
        return $this;
    }

    public function setLocation_arg($location_arg) {
        $this->location_arg = $location_arg;
        return $this;
    }

}
