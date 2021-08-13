<?php

/**
 * ------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * abluxxen implementation : © <Your name here> <Your email address here>
 * 
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 * 
 * abluxxen.game.php
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

class abluxxen extends Table {

    protected function getGameName() {
        return "abluxxen";
    }

}

class abluxxen extends Table {

    CONST TURN_NUMBER = 10;
    CONST AVAILABLE_CARD = 6;
    CONST TYPES_OF_NUMBERS = 13;
    CONST NUMBER_OF_NUMBERS = 8;
    CONST VALUE_OF_JOKERS = 14;
    CONST NUMBER_OF_JOKERS = 5;

    private $takeableCollection = array();

    function __construct() {
        // Your global variables labels:
        //  Here, you can assign labels to global variables you are using for this game.
        //  You can use any number of global variables with IDs between 10 and 99.
        //  If your game has options (variants), you also have to associate here a label to
        //  the corresponding ID in gameoptions.inc.php.
        // Note: afterwards, you can get/set the global variables with getGameStateValue/setGameStateInitialValue/setGameStateValue

        parent::__construct();
        self::initGameStateLabels(array(
            "turnNumber" => self::TURN_NUMBER,
        ));

        $this->cards = self::getNew("module.common.deck");
        $this->cards->init("card");
    }

    protected function getGameName() {
        // Used for translations and stuff. Please do not modify.
        return "abluxxen";
    }

    /*
      setupNewGame utility : setupDeck : create a deck for this game
     */

    private function setupDeck() {
        // Create cards
        $cards = array();
        for ($number = 1; $number <= self::NUMBER_OF_NUMBERS; ++$number) {
            $cards[] = array('type' => $number, 'type_arg' => $number + 1, 'nbr' => self::NUMBER_OF_NUMBERS);
        }
        $cards[] = array('type' => self::VALUE_OF_JOKERS, 'type_arg' => self::VALUE_OF_JOKERS, 'nbr' => self::NUMBER_OF_JOKERS);

        // Create deck, shuffle it and 
        $this->cards->createCards($cards, 'deck');
        $this->cards->moveAllCardsInLocation(null, "deck");
        $this->cards->shuffle('deck');
    }

    /*
      setupNewGame:

      This method is called only once, when a new game is launched.
      In this method, you must setup the game according to the game rules, so that
      the game is ready to be played.
     */

    protected function setupNewGame($players, $options = array()) {
        // Set the colors of the players with HTML color code
        // The default below is red/green/blue/orange/brown
        // The number of colors defined here must correspond to the maximum number of players allowed for the gams
        $gameinfos = self::getGameinfos();
        $default_colors = $gameinfos['player_colors'];

        // Create players
        // Note: if you added some extra field on "player" table in the database (dbmodel.sql), you can initialize it there.
        $sql = "INSERT INTO player (player_id, player_color, player_canal, player_name, player_avatar) VALUES ";
        $values = array();
        foreach ($players as $player_id => $player) {
            $color = array_shift($default_colors);
            $values[] = "('" . $player_id . "','$color','" . $player['player_canal'] . "','" . addslashes($player['player_name']) . "','" . addslashes($player['player_avatar']) . "')";
        }
        $sql .= implode($values, ',');
        self::DbQuery($sql);
        self::reattributeColorsBasedOnPreferences($players, $gameinfos['player_colors']);
        self::reloadPlayersBasicInfos();

        /*         * ********** Start the game initialization **** */
        $this->setupDeck();
        // Deal 13 cards to each players
//        $players = self::loadPlayersBasicInfos();
        foreach ($players as $player_id => $player) {
            $cards = $this->cards->pickCards(13, 'deck', $player_id);
            // Notify player about his cards
            self::notifyPlayer($player_id, 'newHand', '', array('cards' => $cards));
        }

        //Define drawable card
        $this->cards->pickCardsForLocation(self::AVAILABLE_CARD, 'deck', 'draw');

        //intialise players stats
        $this->initializeStatistics();

        // Activate first player (which is in general a good idea :) )
        $this->activeNextPlayer();

        /*         * ********** End of the game initialization **** */
    }

    private function initializeStatistics() {
        $all_stats = $this->getStatTypes();
        $player_stats = $all_stats['player'];

        foreach ($player_stats as $key => $value) {
            if ($value['id'] >= 10) {
                $this->initStat('player', $key, 0);
            }
        }
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

        $current_player_id = self::getCurrentPlayerId();    // !! We must only return informations visible by this player !!
        // Get information about players
        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
        $sql = "SELECT player_id id, player_score score FROM player ";
        $result['players'] = self::getCollectionFromDb($sql);

        // TODO: Gather all information about current game situation (visible by player $current_player_id).
        // Cards in player hand
        $result['hand'] = $this->cards->getCardsInLocation('hand', $current_player_id);

        foreach ($result['players'] as $player) {
            $result['ontable'][$player['id']] = $this->getPlayedCollection($player['id']);
        }

        // Drawable Cards
        $result['drawable'] = $this->cards->getCardsInLocation('draw');

        return $result;
    }

    /**
     *      getAllDatas: utility :
     *      rebuid the played collection of a given player
     */
    private function getPlayedCollection($playerId) {
        $result = array();
        $raw = $this->cards->getCardsInLocation("playertablecard_" . $playerId);

        foreach ($raw as $playedCard) {
            $result[$playedCard['location_arg']][] = $playedCard;
        }

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
//////////// Utility functions
////////////    

    /*
      In this space, you can put any utility methods useful for your game logic
     */
    private function autoTakeCollection($playerId) {
        foreach ($this->takeableCollection as $id_player => $collection) {
            foreach ($collection as $card) {
                $this->cards->moveCard($card['id'], 'hand', $playerId);
            }

            var_dump($this->player);
            die;

            self::notifyAllPlayers('takeCollection', clienttranslate('${player_name} take a serie of $(count_displayed) cards of value $(value_displayed) to ${target_name}'), array(
                'i18n' => array(),
                //'played_cards' => $actionInfos['selectedCards'],
                'player_id' => intval($playerId),
                'player_name' => self::getActivePlayerName(),
                'value' => $collection[0]['type'],
                'value_displayed' => $collection[0]['type'],
                'count_displayed' => sizeof($collection)
            ));
        }
    }

//////////////////////////////////////////////////////////////////////////////
//////////// Player actions
//////////// 
    // utility for playCards Action : Retrive Cards Infos
    private function getPlayedCardsInfos($cardsIds, $playerId) {
        $selectedIds = explode(",", $cardsIds);
        $handCards = $this->cards->getPlayerHand($playerId);
        $selectedCards = array();
        $numbers = array();
        $joker = 0;
        foreach ($handCards as $handCard) {
            if (in_array($handCard['id'], $selectedIds)) {
                $selectedCards[] = $handCard;
                if ('14' === $handCard['type']) {
                    $joker++;
                } elseif (!in_array($handCard['type'], $numbers)) {
                    $numbers[] = $handCard['type'];
                }
            }
        }
        if ((1 !== sizeof($numbers) && 0 === $joker) || sizeof($selectedIds) !== sizeof($selectedCards)) {
            throw new BgaUserException(self::_("Invalid Selection"));
        }
        $value = 0 === sizeof($numbers) ? $numbers[sizeof($numbers)] : '14';

        return array(
//            "numbers" => $numbers,
            "joker" => $joker,
            "selectedIds" => $selectedIds,
            "selectedCards" => $selectedCards,
            "value" => $value
        );
    }

    // utility for playCards Action : Update Player Stats after play action
    private function updPlayStats($actionInfos, $playerId) {
        self::incStat(1, "turns_number", $playerId);
        self::incStat(1, "sequence_count", $playerId);
        self::incStat($actionInfos['joker'], "joker_played", $playerId);
        self::incStat(sizeof($actionInfos['selectedCards']), "played_cards", $playerId);
        //-- Check max sequence length and update if needed
        $actualMaxCollectionSize = self::getStat("max_length_sequence", $playerId);
        if (sizeof($actionInfos['selectedCards']) > $actualMaxCollectionSize) {
            self::setStat(sizeof($actionInfos['selectedCards']), "max_length_sequence", $playerId);
        }
    }

    private function getTakeableCollections($actionInfos, $playerId) {
        $players = self::loadPlayersBasicInfos();
        $result = array();

        foreach ($players as $player) {
            $collections = $this->getPlayedCollection($player['player_id']);
            if ($playerId !== $player['player_id'] && sizeof($collections) > 0) {
                $lastCollectionCard = $collections[sizeof($collections)][0];
                $lastCollectionLength = sizeof($collections[sizeof($collections)]);

                if (sizeof($actionInfos['selectedCards']) === $lastCollectionLength && $lastCollectionCard['type'] < $actionInfos['value']) {
                    $result[$player['player_id']] = $collections[sizeof($collections)];
                }
            }
        }

        return $result;
    }

    public function playCards($cardsIds) {
        //var_dump( self::checkAction("playCards",false));die;
        self::checkAction("playCards");
        $player_id = self::getActivePlayerId();

        $actionInfos = $this->getPlayedCardsInfos($cardsIds, $player_id);

        $posArg = self::getStat("sequence_count", $player_id);
        $this->cards->moveCards($actionInfos['selectedIds'], "playertablecard_" . $player_id, $posArg + 1);

        //-- Update stats
        $this->updPlayStats($actionInfos, $player_id);

        // And notify
        self::notifyAllPlayers('playCards', clienttranslate('${player_name} play a serie of $(count_displayed) cards of value $(value_displayed)'), array(
            'i18n' => array(),
            'played_cards' => $actionInfos['selectedCards'],
            'player_id' => intval($player_id),
            'player_name' => self::getActivePlayerName(),
            'value' => $actionInfos['value'],
            'value_displayed' => $actionInfos['value'],
            'count_displayed' => sizeof($actionInfos['selectedCards'])
        ));

        $this->takeableCollection = $this->getTakeableCollections($actionInfos, $player_id);
        $remindedCards = $this->cards->getPlayerHand($player_id);
        if (sizeof($this->takeableCollection)) {

            $this->autoTakeCollection($player_id);
            // TODO - Kyw : Tempory desactivated for dev rest
            //$this->gamestate->nextState("takeCollection");
        } elseif (sizeof($remindedCards) > 0) {
            $this->gamestate->nextState("nextPlayer");
        } else {
            $this->gamestate->nextState("getFinalScores");
        }
    }

    /*
      Each time a player is doing some game action, one of the methods below is called.
      (note: each method below must match an input method in abluxxen.action.php)
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

    public function stNewTurn() {
        $player_id = self::activeNextPlayer();
        self::giveExtraTime($player_id);
        $this->gamestate->nextState('playerTurn');
    }

    public function stNextPlayer() {
        $player_id = self::activeNextPlayer();
        self::giveExtraTime($player_id);
        $this->gamestate->nextState("nextPlayer");

        //tandard case (not the end of the trick)
        // => just active the next player
        // Active next player OR end the trick and go to the next trick OR end the hand
//        if ($this->cards->countCardInLocation('cardsontable') == 4) {
//            // This is the end of the trick
//            // Move all cards to "cardswon" of the given player
//            $best_value_player_id = self::activeNextPlayer(); // TODO figure out winner of trick
//            $this->cards->moveAllCardsInLocation('cardsontable', 'cardswon', null, $best_value_player_id);
//
//            if ($this->cards->countCardInLocation('hand') == 0) {
//                // End of the hand
//                $this->gamestate->nextState("endHand");
//            } else {
//                // End of the trick
//                $this->gamestate->nextState("nextTrick");
//            }
//        } else {
//            // Standard case (not the end of the trick)
//            // => just active the next player
//            $player_id = self::activeNextPlayer();
//            self::giveExtraTime($player_id);
//            $this->gamestate->nextState('nextPlayer');
//        }
    }

    public function stScoreProcess() {
        $players = self::loadPlayersBasicInfos();
        $scores = array();

        foreach ($players as $player) {
            $hand = $this->cards->getCardsInLocation('hand', $player['player_id']);
            $played = $this->cards->getCardsInLocation('playertablecard_' . $player['player_id']);
            $scores[$player['player_id']] = array(
                "hand" => sizeof($hand),
                "onTable" => sizeof($played),
                "score" => sizeof($played) - sizeof($hand)
            );

            self::DbQuery("UPDATE player SET player_score=" . (sizeof($played) - sizeof($hand)) . " WHERE player_id='" . $player['player_id'] . "'");
        }

        self::notifyAllPlayers('newScores', clienttranslate('${player_name} triggered the end of the game.'), array(
            "player_name" => self::getActivePlayerName(),
            "scores" => $scores
        ));

        $this->gamestate->nextState("End of game");

//        $players = $players = self::loadPlayersBasicInfos();
//        
//        foreach ($players as $player) {
//            //var_dump($player);     
//            $hand = $this->cards->getCardsInLocation('hand', $player['player_id']);
//            $played = $this->cards->getCardsInLocation('playertablecard_' . $player['player_id']);
//            $scores['player_id'] = sizeof($played) - sizeof($hand);
//        }
//        var_dump($scores, $players);
//        die;
    }

//    function stEndHand() {
//        $this->gamestate->nextState("nextHand");
//    }

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

}
