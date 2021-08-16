<?php

namespace Linko\Models;

use Linko\Tools\DB_Manager;

/**
 * Description of Player
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Player extends DB_Manager {

    protected $id;
    protected $no; // natural order
    protected $name; // player name
    protected $color;
    protected $eliminated = false;
    protected $zombie = false;
    protected $score;

    //-- Abstract definitions (required by DB_Manager)
    protected function getPrimary() {
        return 'player_id';
    }

    protected function getTableName() {
        return 'player';
    }

    /* --------------------------------
     *  BEGIN GETTERS & SETTERS
     * --------------------------------
     */

    public function getId() {
        return $this->id;
    }

    public function getNo() {
        return $this->no;
    }

    public function getName() {
        return $this->name;
    }

    public function getColor() {
        return $this->color;
    }

    public function getEliminated() {
        return $this->eliminated;
    }

    public function getZombie() {
        return $this->zombie;
    }

    public function getScore() {
        return $this->score;
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

    public function setColor($color) {
        $this->color = $color;
        return $this;
    }

    public function setEliminated($eliminated) {
        $this->eliminated = $eliminated;
        return $this;
    }

    public function setZombie($zombie) {
        $this->zombie = $zombie;
        return $this;
    }

    public function setScore($score) {
        $this->score = $score;
        return $this;
    }

    /* --------------------------------
     *  END GETTERS & SETTERS
     * --------------------------------
     */
}
