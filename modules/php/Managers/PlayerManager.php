<?php

namespace Linko\Managers;

use Linko;
use Linko\Managers\Factories\PlayerManagerFactory;

/**
 * toolbox to manage players
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerManager extends Manager {

    private static $instance;

    public function __construct() {
        self::$instance = $this;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Define Abstract Methods
     * ---------------------------------------------------------------------- */

    public static function getInstance(): Manager {
        if (null === self::$instance) { //constructer haven't be call yet
            self::$instance = PlayerManagerFactory::create(); // factory construct !
        }
        return self::$instance;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - init
     * ---------------------------------------------------------------------- */

    /**
     * new game initilaze
     * @param array $players : List of player array serialized get from table
     * @param array $options : /!\ Not used at the moment
     */
    public function initForNewGame(array $rawPlayers = array(), array $options = array()) {
        $gameinfos = Linko::getInstance()->getGameinfos();
        $fields = $this->repository->getFields();
        $players = $this->getSerializer()->unserialize($rawPlayers, $fields);

        $defaultColors = $gameinfos['player_colors'];

        foreach ($players as &$player) {
            $color = array_shift($defaultColors);
            $player->setColor($color);
        }

        $this->repository->create($players);

        Linko::getInstance()->reattributeColorsBasedOnPreferences($rawPlayers, $gameinfos['player_colors']);
        Linko::getInstance()->reloadPlayersBasicInfos();

        return $this->repository->setDoUnserialization(true)->getAll();
    }

}
