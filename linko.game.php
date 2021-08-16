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

use Linko\Factories\StatsFactory;
use Linko\Managers\CardsManager;
use Linko\Managers\PlayersManager;

class Linko extends Table {

    CONST GAME_NAME = "Linko";

    private $playerManager;
    private $cardManager;
    protected static $instance = null;

    public function __construct() {
        parent::__construct();
        self::$instance = $this;

        $this->cardManager = new CardsManager();
        $this->playerManager = new PlayersManager();
        //-- TODO Kyw : identify what is called.
        //self::initGameStateLabels([]);
    }

    protected function getGameName() {
        return "Linko";
    }

    public static function getInstance() {
        return self::$instance;
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

        StatsFactory::create($this);

        $this->activeNextPlayer();
    }

    protected function getAllDatas() {
        $pId = self::getCurrentPlayerId();

        return [
            'players' => $this->playerManager->getUiData($pId),
            'deck' => $this->cardManager->getCardInLocation(CardsManager::LOCATION_DECK),
        ];

//        $result = array();
//
//        $current_player_id = self::getCurrentPlayerId();    // !! We must only return informations visible by this player !!
//        // Get information about players
//        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
//        $sql = "SELECT player_id id, player_score score FROM player ";
//        $result['players'] = self::getCollectionFromDb($sql);
//
//        // TODO: Gather all information about current game situation (visible by player $current_player_id).
//        // Cards in player hand
//        $result['hand'] = $this->cards->getCardsInLocation('hand', $current_player_id);
//
//        foreach ($result['players'] as $player) {
//            $result['ontable'][$player['id']] = $this->getPlayedCollection($player['id']);
//        }
//
//        // Drawable Cards
//        $result['drawable'] = $this->cards->getCardsInLocation('draw');
//
//        return $result;
    }

}
