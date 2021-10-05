<?php

namespace Linko\Managers;

use Linko;
use Linko\Managers\Core\SuperManager;
use Linko\Models\Player;
use Linko\Serializers\Serializer;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerManager extends SuperManager {

    private $serializer;

    public function __construct() {
        $this->serializer = new Serializer(Player::class);
    }

    public function initForNewGame(array $rawPlayers = array(), array $options = array()) {
        $gameinfos = Linko::getInstance()->getGameinfos();

        $players = $this->serializer->unserialize($rawPlayers);
//        var_dump($players);die;

        $defaultColors = $gameinfos['player_colors'];
        foreach ($players as &$player) {
            $color = array_shift($defaultColors);
            $player->setColor($color);
        }

        $this->create($players);

//        $defaultColors = $gameinfos['player_colors'];
//        foreach ($players as &$player) {
//            $color = array_shift($defaultColors);
//            
//            
//        }
//        
//        var_dump($gameinfos);
//        $fields = $this->repository->getFields();
//        $players = $this->getSerializer()->unserialize($rawPlayers, $fields);
//
//        $defaultColors = $gameinfos['player_colors'];
//
//        foreach ($players as &$player) {
//            $color = array_shift($defaultColors);
//            $player->setColor($color);
//        }
//
//        $this->repository->create($players);
//
//        Linko::getInstance()->reattributeColorsBasedOnPreferences($rawPlayers, $gameinfos['player_colors']);
//        Linko::getInstance()->reloadPlayersBasicInfos();
//
//        return $this->repository->setDoUnserialization(true)->getAll();
    }
    
    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstracts Methods 
     * ---------------------------------------------------------------------- */

    public function getSerializer() {
        return $this->serializer;
    }

}
