<?php

namespace Linko\Models;

use DateTime;
use Linko\Models\Core\Model;

/**
 * Description of Log
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 * @ORM\Table{"name":"log"}
 */
class Log extends Model {

    /**
     * @var int|null
     * @ORM\Column{"type":"integer", "name":"log_id","exclude":["insert"]}
     * @ORM\Id
     */
    private $id;

    /**
     * 
     * @var DateTime
     * @ORM\Column{"type":"datetime", "name":"log_date"}
     */
    private $date;

    /**
     * 
     * @var string
     * @ORM\Column{"type":"string", "name":"log_category"}
     */
    private $category;

    /**
     * 
     * @var string
     * @ORM\Column{"type":"string", "name":"log_content"}
     */
    private $content;

    /* -------------------------------------------------------------------------
     *                  BEGIN - Constructor
     * ---------------------------------------------------------------------- */

    public function __construct() {
        $this->date = new DateTime();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getId(): ?int {
        return $this->id;
    }

    function getDate(): DateTime {
        return $this->date;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function setId(?int $id) {
        $this->id = $id;
        return $this;
    }

    function setDate(DateTime $date) {
        $this->date = $date;
        return $this;
    }

    public function setCategory(string $category) {
        $this->category = $category;
        return $this;
    }

    public function setContent(string $content) {
        $this->content = $content;
        return $this;
    }

}
