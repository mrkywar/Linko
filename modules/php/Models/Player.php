<?php

namespace Linko\Models;

use Linko\Models\Core\Model;

/**
 * Description of Player
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 * @ORM\Table{"name":"player"}
 */
class Player extends Model {

    /**
     * 
     * @var int|null
     * @ORM\Column{"type":"integer", "name":"player_id", "default":null}
     * @ORM\Id
     */
    private $id;

    /**
     * 
     * @var int|null
     * @ORM\Column{"type":"integer", "name":"player_no", "default":null, "exclude":["insert","update"]}
     * @ORM\Exclude{"insert":true,"update":true}
     */
    private $no;

    /**
     * 
     * @var string
     * @ORM\Column{"type":"string", "name":"player_name"}
     */
    private $name;

    /**
     * 
     * @var string
     * @ORM\Column{"type":"string", "name":"player_color"}
     */
    private $color;

    /**
     * 
     * @var string
     * @ORM\Column{"type":"string", "name":"player_canal"}
     */
    private $canal;

    /**
     * 
     * @var string
     * @ORM\Column{"type":"string", "name":"player_avatar"}
     */
    private $avatar;

    /**
     * 
     * @var bool
     * @ORM\Column{"type":"boolean", "name":"player_ai"}
     */
    private $isAi;

    /**
     * 
     * @var int
     * @ORM\Column{"type":"integer", "name":"player_score"}
     */
    private $score;

    /**
     * 
     * @var bool
     * @ORM\Column{"type":"boolean", "name":"player_zombie"}
     */
    private $isZombie;

    /**
     * 
     * @var bool
     * @ORM\Column{"type":"boolean", "name":"player_eliminated"}
     */
    private $isEliminated;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Constructor
     * ---------------------------------------------------------------------- */

    public function __construct() {
        $this->isAi = false;
        $this->isEliminated = false;
        $this->isZombie = false;
        $this->score = 0;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getId(): ?int {
        return $this->id;
    }

    public function getNo(): ?int {
        return $this->no;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getColor(): string {
        return $this->color;
    }

    public function getCanal(): string {
        return $this->canal;
    }

    public function getAvatar(): string {
        return $this->avatar;
    }

    public function getIsAi(): bool {
        return $this->isAi;
    }

    public function getScore(): int {
        return $this->score;
    }

    public function getIsZombie(): bool {
        return $this->isZombie;
    }

    public function getIsEliminated(): bool {
        return $this->isEliminated;
    }

    public function setId(?int $id) {
        $this->id = $id;
        return $this;
    }

    public function setNo(?int $no) {
        $this->no = $no;
        return $this;
    }

    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }

    public function setColor(string $color) {
        $this->color = $color;
        return $this;
    }

    public function setCanal(string $canal) {
        $this->canal = $canal;
        return $this;
    }

    public function setAvatar(string $avatar) {
        $this->avatar = $avatar;
        return $this;
    }

    public function setIsAi(bool $isAi) {
        $this->isAi = $isAi;
        return $this;
    }

    public function setScore(int $score) {
        $this->score = $score;
        return $this;
    }

    public function setIsZombie(bool $isZombie) {
        $this->isZombie = $isZombie;
        return $this;
    }

    public function setIsEliminated(bool $isEliminated) {
        $this->isEliminated = $isEliminated;
        return $this;
    }

}
