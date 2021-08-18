<?php

namespace Linko\Models;

use Linko\Managers\CardsManager;
use Linko\Serializers\PlayerSerializer;
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
    protected $hand;
    private $serializer;

    public function __construct() {
        $this->serializer = new PlayerSerializer();
    }

    //-- Abstract definitions (required by DB_Manager)
    protected function getPrimary() {
        return 'player_id';
    }

    protected function getTableName() {
        return 'player';
    }

    public function getUiData($currentPlayerId, CardsManager $cardManager) {
        $isCurrent = $this->getId() === $currentPlayerId;

        //$hand = $current ? $this->getHand($this->id)->toArray() : $this->countHand($this->id);
        $handCards = $cardManager->getHand($this);
        $this->setHand($handCards);

        $serializedPlayer = $this->serializer->serialize($this);
        $serializedPlayer['hand'] = $isCurrent ? $handCards->toArray() : sizeof($handCards);
        $serializedPlayer['ingame'] = $cardManager->getPlayedCollections($this);
        
        return $serializedPlayer;
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

    public function getHand() {
        return $this->hand;
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

    public function setHand($hand) {
        $this->hand = $hand;
        return $this;
    }

    /* --------------------------------
     *  END GETTERS & SETTERS
     * --------------------------------
     */
}
