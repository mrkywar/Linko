<?php

namespace Linko\Managers;

use Linko;
use Linko\Managers\Core\SuperManager;
use Linko\Models\Card;
use Linko\Serializers\Serializer;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardManager extends SuperManager {

    private $serializer;

    public function __construct() {
        $this->serializer = new Serializer(Card::class);
    }

    public function initForNewGame(array $options = array()) {

    }
    
    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstracts Methods 
     * ---------------------------------------------------------------------- */

    public function getSerializer() {
        return $this->serializer;
    }

}
