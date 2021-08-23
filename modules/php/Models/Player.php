<?php

namespace Linko\Models;

/**
 * Description of Player
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Player {

    private $id;
    private $no;
    private $name;

    public function getId() {
        return $this->id;
    }

    public function getNo() {
        return $this->no;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNo($no) {
        $this->no = $no;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

}
