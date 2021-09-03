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

        Linko::getInstance()->reattributeColorsBasedOnPreferences($rawPlayers, $gameinfos['player_colors']);
        Linko::getInstance()->reloadPlayersBasicInfos();
    }

}

//
//
//$sql = "INSERT INTO player (player_id, player_color, player_canal, player_name, player_avatar) VALUES ";
//        $values = array();
//        foreach ($players as $player_id => $player) {
//            $color = array_shift($default_colors);
//            $values[] = "('" . $player_id . "','$color','" . $player['player_canal'] . "','" . addslashes($player['player_name']) . "','" . addslashes($player['player_avatar']) . "')";
//        }
//        $sql .= implode($values, ',');
//        self::DbQuery($sql);
//        self::reattributeColorsBasedOnPreferences($players, $gameinfos['player_colors']);
//        self::reloadPlayersBasicInfos();
