<?php

namespace Linko\Managers;

use Linko;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerManager extends Manager {

    public function initNewGame($rawPlayers = null, $options = null) {

        $gameinfos = Linko::getInstance()->getGameinfos();
        $fields = $this->repository->getFields();
        $players = [];

        $default_colors = $gameinfos['player_colors'];

        foreach ($rawPlayers as $player_id => $rawPlayer) {
            $color = array_shift($default_colors);
            $player = $this->getSerializer()->unserializeOnce($rawPlayer, $fields);
            $player->setId($player_id)
                    ->setColor($color);
            $players[] = $player;
        }

        $this->repository->create($players);

        Linko::getInstance()->reattributeColorsBasedOnPreferences($rawPlayers, $gameinfos['player_colors']);
        Linko::getInstance()->reloadPlayersBasicInfos();
    }

}