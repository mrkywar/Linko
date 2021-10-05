<?php

namespace Linko\Tools\DB;

/**
 * Description of DBTable
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class DBTable {

    /**
     * @var string
     */
    private $name;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }

}
