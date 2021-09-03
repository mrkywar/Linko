<?php

namespace Linko\Managers;

use Linko;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerManager extends Manager {

    private $repository;

    public function initNewGame($rawPlayers = null, $options = null) {
        $this->repository = $this->getRepository();

        $gameinfos = Linko::getInstance()->getGameinfos();
        $fields = $this->repository->getFields();
        $players = [];

        $default_colors = $gameinfos['player_colors'];

        foreach ($rawPlayers as $player_id => $rawPlayer) {
            $color = array_shift($default_colors);
            $player = $this->getSerializer()->unserialize($rawPlayer, $fields);
            $player->setId($player_id)
                    ->setColor($color);
            $players[] = $player;
        }

        $this->repository->create($players);

        Linko::getInstance()->reattributeColorsBasedOnPreferences($players, $gameinfos['player_colors']);
        Linko::getInstance()->reloadPlayersBasicInfos();
    }

}