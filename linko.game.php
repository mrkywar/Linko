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
            var_dump("Impossible to load bang class : $class");
        }
    }
};
spl_autoload_register($swdNamespaceAutoload, true, true);

require_once( APP_GAMEMODULE_PATH . 'module/table/table.game.php' );

use Linko\Managers\Players;

class Linko extends Table {

    CONST GAME_NAME = "Linko";

    protected static $instance = null;

    public function __construct() {
        parent::__construct();
        self::$instance = $this;
        //-- TODO Kyw : identify what is called.
        //self::initGameStateLabels([]);
    }

    protected function getGameName() {
        return "Linko";
    }

    public static function getInstance() {
        return self::$instance;
    }

    /*
      setupNewGame:

      This method is called only once, when a new game is launched.
      In this method, you must setup the game according to the game rules, so that
      the game is ready to be played.
     */

    protected function setupNewGame($players, $options = array()) {
        $cardManager = new Linko\Managers\Cards();
        $cardManager->setupNewGame();
        
        $playerManager = new Players();
        $playerManager->setupNewGame($players, $cardManager, $options);
        
        
    }

}
