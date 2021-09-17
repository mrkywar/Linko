<?php

namespace Linko\Models;

use DateTime;
use Linko\Models\Core\Model;

/**
 * Description of State
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class State implements Model {
    private $id;
    private $state;
    private $createdDate;
    private $playedDate;
    private $order;
    private $playerId;
    
    public function __construct() {
        $this->createdDate = new DateTime();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getState() {
        return $this->state;
    }

    public function getCreatedDate() {
        return $this->createdDate;
    }

    public function getPlayedDate() {
        return $this->playedDate;
    }

    public function getOrder() {
        return $this->order;
    }

    public function getPlayerId() {
        return $this->playerId;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    public function setCreatedDate($createdDate) {
        $this->createdDate = $createdDate;
        return $this;
    }

    public function setPlayedDate($playedDate) {
        $this->playedDate = $playedDate;
        return $this;
    }

    public function setOrder($order) {
        $this->order = $order;
        return $this;
    }

    public function setPlayerId($playerId) {
        $this->playerId = $playerId;
        return $this;
    }


}
