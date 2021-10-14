<?php

$machinestates = [
    /*
     * BGA framework initial state. Do not modify.
     */
    ST_BEGIN_GAME => [
        'name' => 'gameSetup',
        'description' => '',
        'type' => 'manager',
        'action' => 'stGameSetup',
        'transitions' => [
            '' => ST_START_OF_TURN,
        ],
    ],
    /*
     * Start of a turn : trigger new player turn
     */
    ST_START_OF_TURN => [
        'name' => 'startOfTurn',
        'description' => '',
        'type' => 'game',
        'action' => 'stStartOfTurn',
        'transitions' => [
            '' => ST_RESOLVE_STATE,
        ],
    ],
    ST_END_OF_TURN => [
        'name' => 'endOfTurn',
        'description' => '',
        'type' => 'game',
        'action' => 'stEndOfTurn',
        'transitions' => [
            '' => ST_RESOLVE_STATE,
        ],
    ],
    ST_RESOLVE_STATE => [
        'name' => 'resolveStack',
        'description' => '',
        'type' => 'game',
        'action' => 'stResolveState',
        'transitions' => [],
    ],
    //-- PLAYER ACTIONS
    ST_PLAYER_PLAY_NUMBER => [
        "name" => "playNumber",
        "description" => clienttranslate('${actplayer} can play card(s)'),
        "descriptionmyturn" => clienttranslate('${you} can play card(s)'),
        "type" => "activeplayer",
        "args" => "argPlayCards",
        "action" => "stPlayCards",
        "possibleactions" => ["playCards"]
    ],
    ST_PLAYER_TAKE_COLLECTION => [
        "name" => "takeCollection",
        "description" => clienttranslate('${actplayer} can steal cards or have ${tarplayer} discard'),
        "descriptionmyturn" => clienttranslate('${you} can steal cards or have ${tarplayer} discard'),
        "type" => "activeplayer",
        "args" => "argStealCollection",
        "action" => "stStealCollection",
        "possibleactions" => ["actionStealCards"]
    ],
    ST_PLAYER_DRAW => [
        "name" => "playerDraw",
        "description" => clienttranslate('${actplayer} should draw ${numberOfCard} card(s)'),
        "descriptionmyturn" => clienttranslate('${you} should draw ${numberOfCard} card(s)'),
        "type" => "activeplayer",
        "args" => "argDrawCards",
        "action" => "stDrawCard",
        "possibleactions" => ["actDrawCards"]
    ],
    /*
     * BGA framework final state. Do not modify.
     */
    ST_END_GAME => [
        'name' => 'gameEnd',
        'description' => clienttranslate('End of game'),
        'type' => 'manager',
        'action' => 'stGameEnd',
        'args' => 'argGameEnd',
    ]
];

