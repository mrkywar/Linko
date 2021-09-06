<?php

namespace Linko\Models;

use Linko\Models\Core\Model;

/**
 * Description of Player
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Player implements Model {

    private $id;
    private $no;
    private $name;
    private $color;
    private $canal;
    private $avatar;
    private $beginner;
    private $isAi;
    private $score;
    private $zombie;
    private $eliminated;

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

    public function getCanal() {
        return $this->canal;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function getBeginner() {
        return $this->beginner;
    }

    public function getIsAi() {
        return $this->isAi;
    }

    public function getScore() {
        return $this->score;
    }

    public function getZombie() {
        return $this->zombie;
    }

    public function getEliminated() {
        return $this->eliminated;
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

    public function setCanal($canal) {
        $this->canal = $canal;
        return $this;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
        return $this;
    }

    public function setBeginner($beginner) {
        $this->beginner = $beginner;
        return $this;
    }

    public function setIsAi($isAi) {
        $this->isAi = $isAi;
        return $this;
    }

    public function setScore($score) {
        $this->score = $score;
        return $this;
    }

    public function setZombie($zombie) {
        $this->zombie = $zombie;
        return $this;
    }

    public function setEliminated($eliminated) {
        $this->eliminated = $eliminated;
        return $this;
    }

}
