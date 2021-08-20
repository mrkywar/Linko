<?php

/**
 * ------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * linko implementation : © <Mr Kywar> <mr.kywar@gmail.com>
 * 
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 * 
 * linko.game.php
 *
 * This is the main file for your game logic.
 *
 * In this PHP file, you are going to defines the rules of the game.
 *
 */
$swdNamespaceAutoload = function ($class) {
    $classParts = explode('\\', $class);
    if ($classParts[0] == 'Linko') {
        array_shift($classParts);
        $file = dirname(__FILE__) . '/modules/php/' . implode(DIRECTORY_SEPARATOR, $classParts) . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            var_dump("Impossible to load linko class : $class");
        }
    }
};
spl_autoload_register($swdNamespaceAutoload, true, true);

require_once( APP_GAMEMODULE_PATH . 'module/table/table.game.php' );

use Linko\Managers\CardsManager;
use Linko\Managers\PlayersManager;
use Linko\Managers\StatsManager;

class Linko extends Table {

    CONST GAME_NAME = "Linko";

    private $playerManager;
    private $cardManager;
    private $statsManager;
    protected static $instance = null;

    public function __construct() {
        parent::__construct();
        self::$instance = $this;

        $this->statsManager = new StatsManager();
        $this->statsManager->setGame($this);

        $this->cardManager = new CardsManager();
        $this->playerManager = new PlayersManager();
        //-- TODO Kyw : identify what is called.
        //self::initGameStateLabels([]);
    }

    protected function getGameName() {
        return self::GAME_NAME;
    }

    /**
     * This method is called only once, when a new game is launched.
     * In this method, you must setup the game according to the game rules, so that
     * the game is ready to be played.
     * 
     * @param type $players
     * @param type $options
     */
    protected function setupNewGame($players, $options = array()) {

        $this->cardManager->setupNewGame();
        $this->playerManager->setupNewGame($players, $this->cardManager, $options);
        //StatsFactory::create($this);

        $this->activeNextPlayer();
    }

    protected function getAllDatas() {
        $pId = self::getCurrentPlayerId();

        return [
            'player_id' => $pId,
            'players' => $this->playerManager->getUiData($pId),
            'deck' => $this->cardManager->getDeck(),
            'visibleDraw' => $this->cardManager->getVisibleDraw()
        ];
    }

    /* --------------------------------
     *  BEGIN Statics Methods
     * --------------------------------
     */

    public static function getDeckModule() {
        return self::getNew("module.common.deck");
    }

    /**
     * 
     * @return Linko
     */
    public static function getInstance() {
        return self::$instance;
    }

    /* --------------------------------
     *  END Statics Methods
     * --------------------------------
     */
}
