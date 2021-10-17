<?php

namespace Linko\Models;

use DateTime;
use Linko\Models\Core\Model;

/**
 * Description of State
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 * @ORM\Table{"name":"state"}
 */
class State extends Model {

    /**
     * @var int|null
     * @ORM\Column{"type":"integer", "name":"state_id", "exclude":["insert"]}
     * @ORM\Id
     */
    private $id;

    /**
     * 
     * @var int
     * @ORM\Column{"type":"int", "name":"state_type"}
     */
    private $state;

    /**
     * 
     * @var DateTime
     * @ORM\Column{"type":"datetime", "name":"state_created_date"}
     */
    private $createdAt;

    /**
     * 
     * @var DateTime|null
     * @ORM\Column{"type":"datetime", "name":"state_played_date", "exclude":["insert"]}
     */
    private $playedAt;

    /**
     * 
     * @var int
     * @ORM\Column{"type":"int", "name":"state_order"}
     */
    private $order;

    /**
     * 
     * @var int|null
     * @ORM\Column{"type":"int", "name":"state_player_id"}
     */
    private $playerId;

    /**
     * 
     * @var string|null
     * @ORM\Column{"type":"json", "name":"state_params", "default":"null"}
     */
    private $params;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Constructor
     * ---------------------------------------------------------------------- */

    public function __construct() {
        $this->createdAt = new DateTime();
        $this->params = "";
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getId(): ?int {
        return $this->id;
    }

    public function getState(): int {
        return $this->state;
    }

    public function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    public function getPlayedAt(): ?DateTime {
        return $this->playedAt;
    }

    public function getOrder(): int {
        return intval($this->order);
    }

    public function getPlayerId(): ?int {
        return $this->playerId;
    }

    public function getParams(): ?string {
        return $this->params;
    }

    public function setId(?int $id) {
        $this->id = $id;
        return $this;
    }

    public function setState(int $state) {
        $this->state = $state;
        return $this;
    }

    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setPlayedAt(?DateTime $playedAt) {
        $this->playedAt = $playedAt;
        return $this;
    }

    public function setOrder(int $order) {
        $this->order = $order;
        return $this;
    }

    public function setPlayerId(?int $playerId) {
        $this->playerId = $playerId;
        return $this;
    }

    public function setParams(?string $params) {
        $this->params = $params;
        return $this;
    }

}
