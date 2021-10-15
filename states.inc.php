<?php

$machinestates = [
    // The initial state. Please do not modify.
    ST_BEGIN_GAME => [
        'name' => 'gameSetup',
        'description' => clienttranslate("Game setup"),
        'type' => 'manager',
        'action' => 'stGameSetup',
        'transitions' => [
            '' => ST_START_OF_TURN,
        ],
    ],
    ST_START_OF_TURN => [
        "name" => "nextPlayer",
        "description" => "",
        "type" => "game",
        "action" => "stStartOfTurn",
        "transitions" => [
            "nextPlayer" => ST_PLAYER_PLAY_NUMBER
        ]
    ],
    ST_PLAYER_PLAY_NUMBER => [
        "name" => "playNumber",
        "description" => clienttranslate('${actplayer} can play card(s)'),
        "descriptionmyturn" => clienttranslate('${you} can play card(s)'),
        "type" => "activeplayer",
        "possibleactions" => ["playCards"],
        "transitions" => [
            "nextPlayer" => ST_START_OF_TURN
        ]

    // array(/*, "takeCollection" => STATE_TAKE_COLLECTION, "getFinalScores" => STATE_FINAL_SCORE*/)
    ],
    // BGA framework final state. Do not modify.
    ST_END_GAME => [
        'name' => 'gameEnd',
        'description' => clienttranslate('End of game'),
        'type' => 'manager',
        'action' => 'stGameEnd',
        'args' => 'argGameEnd',
    ]
];

/* -----------------------------------------------------------------------------
 *                                  OLD
 * -------------------------------------------------------------------------- */
//if (!defined("STATE_END_GAME")) {
//    define("STATE_NEW_TURN", 20);
//    define("STATE_PLAYER_TURN", 21);
//    define("STATE_TAKE_COLLECTION", 30);
//    define("STATE_NEXT_PLAYER", 60);
//
//    define("STATE_BEGIN_GAME", 1);
//    define("STATE_FINAL_SCORE", 98);
//    define('STATE_END_GAME', 99);
//}



//$machinestates = array(
//    // The initial state. Please do not modify.
                                                                                //    ST_BEGIN_GAME => array(
                                                                                //        "name" => "gameSetup",
                                                                                //        "description" => clienttranslate("Game setup"),
                                                                                //        "type" => "manager",
                                                                                //        "action" => "stGameSetup",
                                                                                //        "transitions" => array("" => STATE_NEXT_PLAYER)
                                                                                //    ),
//    /// New hand
////    STATE_NEW_TURN => array(
////        "name" => "newTurn",
////        "description" => "",
////        "type" => "game",
////        "action" => "stNewTurn",
////        "possibleactions" => array("playCards"),
////        "updateGameProgression" => true,
////        "transitions" => array("player" => STATE_PLAYER_TURN)
////    ),
                                                                                //    STATE_PLAYER_TURN => array(
                                                                                //        "name" => "playerTurn",
                                                                                //        "description" => clienttranslate('${actplayer} must play card(s)'),
                                                                                //        "descriptionmyturn" => clienttranslate('${you} must play card(s)'),
                                                                                //        "type" => "activeplayer",
                                                                                //        "possibleactions" => array("playCards"),
                                                                                //        "transitions" => array("nextPlayer" => STATE_NEXT_PLAYER, "takeCollection" => STATE_TAKE_COLLECTION, "getFinalScores" => STATE_FINAL_SCORE)
                                                                                //    ),
                                                                                //    STATE_NEXT_PLAYER => array(
                                                                                //        "name" => "nextPlayer",
                                                                                //        "description" => "",
                                                                                //        "type" => "game",
                                                                                //        "action" => "stNextPlayer",
                                                                                //        "transitions" => array("nextPlayer" => STATE_PLAYER_TURN)
                                                                                //    ),
//    STATE_TAKE_COLLECTION => array(
//        "name" => "takeCollection",
//        "description" => clienttranslate('${actplayer} can take collection'),
//        "descriptionmyturn" => clienttranslate('${you} can take collection'),
//        "type" => "activeplayer",
//        "possibleactions" => array("takeCollection", "drawCollection"),
//        "transitions" => array("nextPlayer" => STATE_PLAYER_TURN, "takeCollection" => STATE_TAKE_COLLECTION)
//    ),
////    /// New hand
////    20 => array(
////        "name" => "newHand",
////        "description" => "",
////        "type" => "game",
////        "action" => "stNewHand",
////        "updateGameProgression" => true,
////        "transitions" => array("" => 30)
////    ),
////    21 => array(
////        "name" => "giveCards",
////        "description" => clienttranslate('Some players must choose 3 cards to give to ${direction}'),
////        "descriptionmyturn" => clienttranslate('${you} must choose 3 cards to give to ${direction}'),
////        "type" => "multipleactiveplayer",
////        "action" => "stGiveCards",
////        "args" => "argGiveCards",
////        "possibleactions" => array("giveCards"),
////        "transitions" => array("giveCards" => 22, "skip" => 22)
////    ),
////    22 => array(
////        "name" => "takeCards",
////        "description" => "",
////        "type" => "game",
////        "action" => "stTakeCards",
////        "transitions" => array("startHand" => 30, "skip" => 30)
////    ),
////    // Trick
////    30 => array(
////        "name" => "newTrick",
////        "description" => "",
////        "type" => "game",
////        "action" => "stNewTrick",
////        "transitions" => array("" => 31)
////    ),
////    31 => array(
////        "name" => "playerTurn",
////        "description" => clienttranslate('${actplayer} must play a card'),
////        "descriptionmyturn" => clienttranslate('${you} must play a card'),
////        "type" => "activeplayer",
////        "possibleactions" => array("playCard"),
////        "transitions" => array("playCard" => 32)
////    ),
////    32 => array(
////        "name" => "nextPlayer",
////        "description" => "",
////        "type" => "game",
////        "action" => "stNextPlayer",
////        "transitions" => array("nextPlayer" => 31, "nextTrick" => 30, "endHand" => 40)
////    ),
////    // End of the hand (scoring, etc...)
////    40 => array(
////        "name" => "endHand",
////        "description" => "",
////        "type" => "game",
////        "action" => "stEndHand",
////        "transitions" => array("nextHand" => 20, "endGame" => 99)
////    ),
//    STATE_FINAL_SCORE => array(
//        "name" => "finalScores",
//        "description" => clienttranslate(""),
//        "type" => "manager",
//        "action" => "stScoreProcess",
//        "transitions" => array("End of game" => STATE_END_GAME)
//    ),

//);


/* -----------------------------------------------------------------------------
 *                                  ACTUAL
 * -------------------------------------------------------------------------- */


//
//$machinestates = [
//    /*
//     * BGA framework initial state. Do not modify.
//     */

//    /*
//     * Start of a turn : trigger new player turn
//     */
//    ST_START_OF_TURN => [
//        'name' => 'startOfTurn',
//        'description' => '',
//        'type' => 'game',
//        'action' => 'stStartOfTurn',
//        'transitions' => [
//            '' => ST_RESOLVE_STATE,
//        ],
//    ],
//    ST_END_OF_TURN => [
//        'name' => 'endOfTurn',
//        'description' => '',
//        'type' => 'game',
//        'action' => 'stEndOfTurn',
//        'transitions' => [
//            '' => ST_RESOLVE_STATE,
//        ],
//    ],
//    ST_RESOLVE_STATE => [
//        'name' => 'resolveStack',
//        'description' => '',
//        'type' => 'game',
//        'action' => 'stResolveState',
//        'transitions' => [],
//    ],
//    //-- PLAYER ACTIONS
//    ST_PLAYER_PLAY_NUMBER => [
//        "name" => "playNumber",
//        "description" => clienttranslate('${actplayer} can play card(s)'),
//        "descriptionmyturn" => clienttranslate('${you} can play card(s)'),
//        "type" => "activeplayer",
//        "args" => "argPlayCards",
//        "action" => "stPlayCards",
//        "possibleactions" => ["playCards"]
//    ],
//    ST_PLAYER_TAKE_COLLECTION => [
//        "name" => "takeCollection",
//        "description" => clienttranslate('${actplayer} can steal cards or have ${tarplayer} discard'),
//        "descriptionmyturn" => clienttranslate('${you} can steal cards or have ${tarplayer} discard'),
//        "type" => "activeplayer",
//        "args" => "argStealCollection",
//        "action" => "stStealCollection",
//        "possibleactions" => ["actionStealCards"]
//    ],
//    ST_PLAYER_DRAW => [
//        "name" => "playerDraw",
//        "description" => clienttranslate('${actplayer} should draw ${numberOfCard} card(s)'),
//        "descriptionmyturn" => clienttranslate('${you} should draw ${numberOfCard} card(s)'),
//        "type" => "activeplayer",
//        "args" => "argDrawCards",
//        "action" => "stDrawCard",
//        "possibleactions" => ["actDrawCards"]
//    ],
//   
//];

