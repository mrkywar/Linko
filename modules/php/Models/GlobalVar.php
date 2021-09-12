<?php

use Linko\Models\Model;

namespace Linko\Models;

/**
 * Description of Global
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class GlobalVar implements Model {

    private $id;
    private $name;
    private $value;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

}
