<?php

namespace Linko\States;

/**
 * Description of State
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class State {

    /**
     * @var int
     */
    private $id;
    /**
     * @var bool
     */
    private $isSupended = false;
    /** 
     * @var int
     */
    private $state;
    /** 
     * @var int|null
     */
    private $playerId;


    public function getId(): int {
        return $this->id;
    }

    public function getIsSupended(): bool {
        return $this->isSupended;
    }

    public function getState(): int {
        return $this->state;
    }

    public function getPlayerId(): ?int {
        return $this->playerId;
    }

    public function setId(int $id) {
        $this->id = $id;
        return $this;
    }

    public function setIsSupended(bool $isSupended) {
        $this->isSupended = $isSupended;
        return $this;
    }

    public function setState(int $state) {
        $this->state = $state;
        return $this;
    }

    public function setPlayerId(?int $playerId) {
        $this->playerId = $playerId;
        return $this;
    }


}
