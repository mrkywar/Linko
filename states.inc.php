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
 * states.inc.php
 *
 * Linko game states description
 *
 */
if (!defined("STATE_END_GAME")) {
    define("STATE_NEW_TURN", 20);
    define("STATE_PLAYER_TURN", 21);
    define("STATE_TAKE_COLLECTION", 30);
    define("STATE_NEXT_PLAYER", 60);

    define("STATE_BEGIN_GAME", 1);
    define("STATE_FINAL_SCORE", 98);
    define('STATE_END_GAME', 99);
}



$machinestates = array(
// The initial state. Please do not modify.
    STATE_BEGIN_GAME => array(
        "name" => "gameSetup",
        "description" => clienttranslate("Game setup"),
        "type" => "manager",
        "action" => "stGameSetup",
        "transitions" => array("firstPlayer" => STATE_NEXT_PLAYER)
    ),
    /// New hand
//    STATE_NEW_TURN => array(
//        "name" => "newTurn",
//        "description" => "",
//        "type" => "game",
//        "action" => "stNewTurn",
//        "possibleactions" => array("playCards"),
//        "updateGameProgression" => true,
//        "transitions" => array("player" => STATE_PLAYER_TURN)
//    ),
    STATE_PLAYER_TURN => array(
        "name" => "playerTurn",
        "description" => clienttranslate('${actplayer} must play card(s)'),
        "descriptionmyturn" => clienttranslate('${you} must play card(s)'),
        "type" => "activeplayer",
        "possibleactions" => array("playCards"),
        "transitions" => array(
            "nextPlayer" => STATE_NEXT_PLAYER,
            "takeCollection" => STATE_TAKE_COLLECTION,
            "getFinalScores" => STATE_FINAL_SCORE
        )
    ),
    STATE_NEXT_PLAYER => array(
        "name" => "nextPlayer",
        "description" => "",
        "type" => "game",
        "action" => "stNextPlayer",
        "transitions" => array("nextPlayer" => STATE_PLAYER_TURN)
    ),
    STATE_TAKE_COLLECTION => array(
        "name" => "takeCollection",
        "description" => clienttranslate('${actplayer} can take collection'),
        "descriptionmyturn" => clienttranslate('${you} can take collection'),
        "type" => "activeplayer",
        "possibleactions" => array("takeCollection", "drawCollection"),
        "transitions" => array(
            "nextPlayer" => STATE_PLAYER_TURN,
            "takeCollection" => STATE_TAKE_COLLECTION
        )
    ),
//    /// New hand
//    20 => array(
//        "name" => "newHand",
//        "description" => "",
//        "type" => "game",
//        "action" => "stNewHand",
//        "updateGameProgression" => true,
//        "transitions" => array("" => 30)
//    ),
//    21 => array(
//        "name" => "giveCards",
//        "description" => clienttranslate('Some players must choose 3 cards to give to ${direction}'),
//        "descriptionmyturn" => clienttranslate('${you} must choose 3 cards to give to ${direction}'),
//        "type" => "multipleactiveplayer",
//        "action" => "stGiveCards",
//        "args" => "argGiveCards",
//        "possibleactions" => array("giveCards"),
//        "transitions" => array("giveCards" => 22, "skip" => 22)
//    ),
//    22 => array(
//        "name" => "takeCards",
//        "description" => "",
//        "type" => "game",
//        "action" => "stTakeCards",
//        "transitions" => array("startHand" => 30, "skip" => 30)
//    ),
//    // Trick
//    30 => array(
//        "name" => "newTrick",
//        "description" => "",
//        "type" => "game",
//        "action" => "stNewTrick",
//        "transitions" => array("" => 31)
//    ),
//    31 => array(
//        "name" => "playerTurn",
//        "description" => clienttranslate('${actplayer} must play a card'),
//        "descriptionmyturn" => clienttranslate('${you} must play a card'),
//        "type" => "activeplayer",
//        "possibleactions" => array("playCard"),
//        "transitions" => array("playCard" => 32)
//    ),
//    32 => array(
//        "name" => "nextPlayer",
//        "description" => "",
//        "type" => "game",
//        "action" => "stNextPlayer",
//        "transitions" => array("nextPlayer" => 31, "nextTrick" => 30, "endHand" => 40)
//    ),
//    // End of the hand (scoring, etc...)
//    40 => array(
//        "name" => "endHand",
//        "description" => "",
//        "type" => "game",
//        "action" => "stEndHand",
//        "transitions" => array("nextHand" => 20, "endGame" => 99)
//    ),
    STATE_FINAL_SCORE => array(
        "name" => "finalScores",
        "description" => clienttranslate(""),
        "type" => "manager",
        "action" => "stScoreProcess",
        "transitions" => array("End of game" => STATE_END_GAME)
    ),
    // Final state.
    // Please do not modify.
    STATE_END_GAME => array(
        "name" => "gameEnd",
        "description" => clienttranslate("End of game"),
        "type" => "manager",
        "action" => "stGameEnd",
        "args" => "argGameEnd"
    )
);

