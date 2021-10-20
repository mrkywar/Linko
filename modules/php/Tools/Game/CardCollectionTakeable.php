<?php

namespace Linko\Tools\Game;

use Linko\Managers\PlayerManager;
use Linko\Models\Player;

/**
 * Description of CardCollectionTakeable
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardCollectionTakeable {
    
    /**
     * @var PlayerManager
     */
    private $playerManager;
    
    public function __construct() {
        $this->playerManager = new PlayerManager();
    }


    public function getTakeableCollections($cards, Player $activePlayer) {
        $players = $this->playerManager->findBy();
        foreach ($players as $player){
            if($activePlayer->getId() !== $player->getId()){
                
            }
        }
    }
    
    
   
}
