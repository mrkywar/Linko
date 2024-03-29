<?php

use Linko\Managers\CardManager;
use Linko\Managers\PlayerManager;
use Linko\Managers\StateManager;
use Linko\States\Traits\EndOfGameTrait;
use Linko\States\Traits\PlayTrait;
use Linko\States\Traits\TurnTrait;
use Linko\Tools\Game\GameDataRetiver;
use Linko\Tools\Logger\Logger;

$swdNamespaceAutoload = function ($class) {
    $classParts = explode('\\', $class);
    if ($classParts[0] == 'Linko') {
        array_shift($classParts);
        $file = dirname(__FILE__) . '/modules/php/' . implode(DIRECTORY_SEPARATOR, $classParts) . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            var_dump("Impossible to load Linko class : $class");
        }
    }
};
spl_autoload_register($swdNamespaceAutoload, true, true);

require_once( APP_GAMEMODULE_PATH . 'module/table/table.game.php' );

class Linko extends Table {

    use TurnTrait;
    use PlayTrait;
    use EndOfGameTrait;

    /**
     * 
     * @var Linko
     */
    private static $instance;

    /**
     * @var CardManager
     */
    private $cardManager;

    /**
     * @var PlayerManager
     */
    private $playerManager;

    /**
     * @var StateManager
     */
    private $stateManager;

    public function __construct() {
        // Your global variables labels:
        //  Here, you can assign labels to global variables you are using for this game.
        //  You can use any number of global variables with IDs between 10 and 99.
        //  If your game has options (variants), you also have to associate here a label to
        //  the corresponding ID in gameoptions.inc.php.
        // Note: afterwards, you can get/set the global variables with getGameStateValue/setGameStateInitialValue/setGameStateValue
        parent::__construct();

        $this->cardManager = new CardManager();
        $this->playerManager = new PlayerManager();
        $this->stateManager = new StateManager();

        self::$instance = $this;

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
        // Used for translations and stuff. Please do not modify.
        return "linko";
    }

    /*
      setupNewGame:

      This method is called only once, when a new game is launched.
      In this method, you must setup the game according to the game rules, so that
      the game is ready to be played.
     */

    protected function setupNewGame($players, $options = array()) {
        
        $this->stateManager->initNewGame();
        $this->playerManager->initNewGame($players, $options);
        $this->cardManager->initNewGame($players, $options);

        Logger::log("INIT OK", "GameSetup");

//        die('... GAME');

        /*         * ********** Start the game initialization **** */

        // Init global values with their initial values
        //self::setGameStateInitialValue( 'my_first_global_variable', 0 );
        // Init game statistics
        // (note: statistics used in this file must be defined in your stats.inc.php file)
        //self::initStat( 'table', 'table_teststat1', 0 );    // Init a table statistics
        //self::initStat( 'player', 'player_teststat1', 0 );  // Init a player statistics (for all players)
        // TODO: setup the initial game situation here
        // Activate first player (which is in general a good idea :) )
        $this->activeNextPlayer();
//        Logger::log("PID ",$playerId);

        /*         * ********** End of the game initialization **** */
    }

    /*
      getAllDatas:

      Gather all informations about current game situation (visible by the current player).

      The method is called each time the game interface is displayed to a player, ie:
      _ when the game starts
      _ when a player refreshes the game page (F5)
     */

    protected function getAllDatas() {
        $currentPlayer = $this->playerManager->findBy([
            "id" => self::getCurrentPlayerId()
        ]);

        $this->stateManager->getNextOrder();

        return GameDataRetiver::retriveForPlayer($currentPlayer);
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
//////////// Utility functions
////////////    

    /*
      In this space, you can put any utility methods useful for your game logic
     */



//////////////////////////////////////////////////////////////////////////////
//////////// Player actions
//////////// 

    /*
      Each time a player is doing some game action, one of the methods below is called.
      (note: each method below must match an input method in linko.action.php)
     */

    /*

      Example:

      function playCard( $card_id )
      {
      // Check that this is the player's turn and that it is a "possible action" at this game state (see states.inc.php)
      self::checkAction( 'playCard' );

      $player_id = self::getActivePlayerId();

      // Add your game logic to play a card there
      ...

      // Notify all players about the card played
      self::notifyAllPlayers( "cardPlayed", clienttranslate( '${player_name} plays ${card_name}' ), array(
      'player_id' => $player_id,
      'player_name' => self::getActivePlayerName(),
      'card_name' => $card_name,
      'card_id' => $card_id
      ) );

      }

     */


//////////////////////////////////////////////////////////////////////////////
//////////// Game state arguments
////////////

    /*
      Here, you can create methods defined as "game state arguments" (see "args" property in states.inc.php).
      These methods function is to return some additional information that is specific to the current
      game state.
     */

    /*

      Example for game state "MyGameState":

      function argMyGameState()
      {
      // Get some values from the current game situation in database...

      // return values:
      return array(
      'variable1' => $value1,
      'variable2' => $value2,
      ...
      );
      }
     */

//////////////////////////////////////////////////////////////////////////////
//////////// Game state actions
////////////

    /*
      Here, you can create methods defined as "game state actions" (see "action" property in states.inc.php).
      The action method of state X is called everytime the current game state is set to X.
     */

    /*

      Example for game state "MyGameState":

      function stMyGameState()
      {
      // Do some stuff ...

      // (very often) go to another gamestate
      $this->gamestate->nextState( 'some_gamestate_transition' );
      }
     */

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

    public static function getInstance(): Linko {
        return self::$instance;
    }

    public function getCardManager(): CardManager {
        return $this->cardManager;
    }

    public function getPlayerManager(): PlayerManager {
        return $this->playerManager;
    }

    public function getStateManager(): StateManager {
        return $this->stateManager;
    }

}
