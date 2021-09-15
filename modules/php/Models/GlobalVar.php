<?php
namespace Linko\Models;

use Linko\Models\Core\Model;


/**
 * Description of Global
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class GlobalVar implements Model {
    const ACTIVE_PLAYER = 101;
    const STACK_STATE = 102;
    
    private $id;
    private $value;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getId() {
        return $this->id;
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


}
