<?php

namespace Linko\Models;

use Linko\Managers\Deck\Deck;
use Linko\Models\Core\Model;

/**
 * Description of Card
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 * @ORM\Table{"name":"card"}
 */
class Card extends Model {

    /**
     * @var int|null
     * @ORM\Column{"type":"integer", "name":"card_id", "exclude":["insert"]}
     * @ORM\Id
     */
    private $id;

    /**
     * 
     * @var int
     * @ORM\Column{"type":"int", "name":"card_type"}
     */
    private $type;

    /**
     * 
     * @var string
     * @ORM\Column{"type":"string", "name":"card_location"}
     */
    private $location;

    /**
     * 
     * @var int
     * @ORM\Column{"type":"int", "name":"card_location_arg"}
     */
    private $locationArg;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Constructor
     * ---------------------------------------------------------------------- */

    public function __construct() {
        $this->locationArg = 0;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Check 
     * ---------------------------------------------------------------------- */

    public function isInHand(Player $player) {
        return (
                (Deck::LOCATION_HAND === $this->getLocation()) &&
                $player->getId() === intval($this->getLocationArg())
        );
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getId(): ?int {
        return $this->id;
    }

    public function getType(): int {
        return $this->type;
    }

    public function getLocation(): string {
        return $this->location;
    }

    public function getLocationArg(): int {
        return $this->locationArg;
    }

    public function setId(?int $id) {
        $this->id = $id;
        return $this;
    }

    public function setType(int $type) {
        $this->type = $type;
        return $this;
    }

    public function setLocation(string $location) {
        $this->location = $location;
        return $this;
    }

    public function setLocationArg(int $locationArg) {
        $this->locationArg = $locationArg;
        return $this;
    }

}
