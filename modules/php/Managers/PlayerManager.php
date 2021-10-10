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

    public function initForNewGame(array $rawPlayers = array(), array $options = array()) {
        $gameinfos = Linko::getInstance()->getGameinfos();

        $players = $this->getSerializer()->unserialize($rawPlayers);

        $defaultColors = $gameinfos['player_colors'];
        foreach ($players as &$player) {
            $color = array_shift($defaultColors);
            $player->setColor($color);
        }

        $this->create($players);

        Linko::getInstance()->reattributeColorsBasedOnPreferences($rawPlayers, $gameinfos['player_colors']);
        Linko::getInstance()->reloadPlayersBasicInfos();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstracts Methods 
     * ---------------------------------------------------------------------- */

    protected function initSerializer(): Serializer {
        return new Serializer(Player::class);
    }

}
