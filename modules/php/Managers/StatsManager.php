<?php

namespace Linko\Managers;

use Linko;

/**
 * Description of Stats
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class StatsManager {

    const PLAYER_STAT = "player";

    private $game;
    private $type;
    private $name;
    private $value;

   

    private function init($type, $name, $value = 0) {
        $this->game->initStat($type, $name, $value); //initStat('player', $key, 0);
        return $this;
    }

    public function initPlayerStat($name) {
        return $this->init(self::PLAYER_STAT, $name);
    }

    /* --------------------------------
     *  BEGIN GETTERS & SETTERS
     * --------------------------------
     */
    
    public function getGame() {
        return $this->game;
    }

    public function setGame(Linko $game) {
        //var_dump($game instanceof Table);die;
        $this->game = $game;
        return $this;
    }



//    public function getType() {
//        return $this->type;
//    }
//
//    public function getName() {
//        return $this->name;
//    }
//
//    public function getValue() {
//        return $this->value;
//    }
//
//    public function setType($type) {
//        $this->type = $type;
//        return $this;
//    }
//
//    public function setName($name) {
//        $this->name = $name;
//        return $this;
//    }
//
//    public function setValue($value) {
//        $this->value = $value;
//        return $this;
//    }

    /* --------------------------------
     *  END GETTERS & SETTERS
     * --------------------------------
     */
}
