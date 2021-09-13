<?php

namespace Linko\Models;

use Linko\Models\Core\Model;

/**
 * Description of Player
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Log implements Model {
    CONST DEBUG_CATEGORY = "debug";

    private $id;
    private $date;
    private $category;
    private $content;

    public function __construct() {
        $this->category = self::DEBUG_CATEGORY; // default
    }

    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getContent() {
        return $this->content;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function setCategory($category) {
        $this->category = $category;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

}
