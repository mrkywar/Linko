<?php

/**
 * ------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * Linko implementation : © <Your name here> <Your email address here>
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
    if ("Linko" === $classParts[0]) {
        array_shift($classParts);
        $file = dirname(__FILE__) . '/modules/php/' . implode(DIRECTORY_SEPARATOR, $classParts) . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            var_dump("Missing Linko class : $class");
        }
    }
};
spl_autoload_register($swdNamespaceAutoload, true, true);

require_once( APP_GAMEMODULE_PATH . 'module/table/table.game.php' );

use Linko\Game\PlayCardsTrait;
use Linko\Game\TurnTrait;
use Linko\Managers\CardManager;
use Linko\Managers\PlayerManager;

class Linko extends Table {

    use TurnTrait; //-- Next Player
    use PlayCardsTrait; //-- Player Play Cards

    private $playerManager;
    private $cardManager;
    private static $instance = null;

    public function __construct() {
        parent::__construct();

        self::$instance = $this;
        $this->cardManager = new CardManager();
        //$this->cardManager->setDeckModule(self::getNew("module.common.deck"));
        $this->playerManager = new PlayerManager();

        self::initGameStateLabels(array(
                //    "my_first_global_variable" => 10,
                //    "my_second_global_variable" => 11,
                //      ...
                //    "my_first_game_variant" => 100,
                //    "my_second_game_variant" => 101,
                //      ...
        ));
    }

    protected function getGameName() {
        return "linko";
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
        $this->playerManager->setupNewGame($players, $options);
//        $oPlayers = $this->playerManager->getAllPlayers();
//        var_dump($oPlayers);die;
//        

        $this->cardManager->setupNewGame($this->playerManager->getAllPlayers());

        $this->activeNextPlayer();
    }

    /*
      getAllDatas:

      Gather all informations about current game situation (visible by the current player).

      The method is called each time the game interface is displayed to a player, ie:
      _ when the game starts
      _ when a player refreshes the game page (F5)
     */

    protected function getAllDatas() {
        $result = array();

        $players = $this->playerManager->getAllPlayers();

        $currentPlayer = $this->playerManager->getCurrentPlayer();
        $result['players'] = $this->playerManager->getAllPlayersUi();
        $result['hand'] = $this->cardManager->getCardsInHand($currentPlayer);
//        $result['handInfos'] = $this->cardManager->getHandsInfos($players);
//
////        $pm = new PlayerManager();
////        $pm->getAllPlayers();
//
//        $current_player_id = self::getCurrentPlayerId();    // !! We must only return informations visible by this player !!
//        // Get information about players
//        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
//        $sql = "SELECT player_id id, player_score score FROM player ";
//        $result['players'] = self::getCollectionFromDb($sql);
        // TODO: Gather all information about current game situation (visible by player $current_player_id).

        return $result;
    }

    /*
      getGameProgression:

      Compute and return the current game progression.
      The number returned must be an integer beween 0 (=the game just started) and
      100 (= the game is finished or almost finished).

      This method is called each time we are in a game state with the "updateGameProgression" property set to true
      (see states.inc.php)
     */

    function getGameProgression() {
        // TODO: compute and return the game progression

        return 0;
    }

//////////////////////////////////////////////////////////////////////////////
//////////// Zombie
////////////

    /*
      zombieTurn:

      This method is called each time it is the turn of a player who has quit the game (= "zombie" player).
      You can do whatever you want in order to make sure the turn of this player ends appropriately
      (ex: pass).

      Important: your zombie code will be called when the player leaves the game. This action is triggered
      from the main site and propagated to the gameserver from a server, not from a browser.
      As a consequence, there is no current player associated to this action. In your zombieTurn function,
      you must _never_ use getCurrentPlayerId() or getCurrentPlayerName(), otherwise it will fail with a "Not logged" error message.
     */

    function zombieTurn($state, $active_player) {
        $statename = $state['name'];

        if ($state['type'] === "activeplayer") {
            switch ($statename) {
                default:
                    $this->gamestate->nextState("zombiePass");
                    break;
            }

            return;
        }

        if ($state['type'] === "multipleactiveplayer") {
            // Make sure player is in a non blocking status for role turn
            $this->gamestate->setPlayerNonMultiactive($active_player, '');

            return;
        }

        throw new feException("Zombie mode not supported at this game state: " . $statename);
    }

///////////////////////////////////////////////////////////////////////////////////:
////////// DB upgrade
//////////

    /*
      upgradeTableDb:

      You don't have to care about this until your game has been published on BGA.
      Once your game is on BGA, this method is called everytime the system detects a game running with your old
      Database scheme.
      In this case, if you change your Database scheme, you just have to apply the needed changes in order to
      update the game database and allow the game to continue to run with your new version.

     */

    function upgradeTableDb($from_version) {
        // $from_version is the current version of this game database, in numerical form.
        // For example, if the game was running with a release of your game named "140430-1345",
        // $from_version is equal to 1404301345
        // Example:
//        if( $from_version <= 1404301345 )
//        {
//            // ! important ! Use DBPREFIX_<table_name> for all tables
//
//            $sql = "ALTER TABLE DBPREFIX_xxxxxxx ....";
//            self::applyDbUpgradeToAllDB( $sql );
//        }
//        if( $from_version <= 1405061421 )
//        {
//            // ! important ! Use DBPREFIX_<table_name> for all tables
//
//            $sql = "CREATE TABLE DBPREFIX_xxxxxxx ....";
//            self::applyDbUpgradeToAllDB( $sql );
//        }
//        // Please add your future database scheme changes here
//
//
    }
    
    /* -------------------------------------------------------------------------
     *                  BEGIN -  Exposing protected methods, 
     *                          please use at your own risk 
     * ---------------------------------------------------------------------- */

    // Exposing protected method getCurrentPlayerId
    public static function getCurrentPId() {
        return self::getCurrentPlayerId();
    }

    // Exposing protected method translation
    public function translate($text) {
        return self::_($text);
    }
    
//    public function loadDeckModule(){
//        return self::getNew("module.common.deck");
//    }

}
