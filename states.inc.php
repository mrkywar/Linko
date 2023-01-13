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
    ST_END_OF_TURN => [
        "name" => "finishedTurn",
        "description" => "",
        "type" => "game",
        "action" => "stEndOfTurn",
        "transitions" => [
            "nextPlayer" => ST_START_OF_TURN
        ]
    ],
    ST_PLAYER_PLAY_NUMBER => [
        "name" => "playNumber",
        "description" => clienttranslate('${actplayer} can play card(s)'),
        "descriptionmyturn" => clienttranslate('${you} can play card(s)'),
        "type" => "activeplayer",
        "possibleactions" => ["playCards"],
        "transitions" => [
            "" => ST_RESOLVE_STATE
        ]

    // array(/*, "takeCollection" => STATE_TAKE_COLLECTION, "getFinalScores" => STATE_FINAL_SCORE*/)
    ],
    ST_PLAYER_CHOOSE => [
        "name" => "takeCollection",
        "description" => clienttranslate('${actplayer} can steal cards or have discard '),
        "descriptionmyturn" => clienttranslate('${you} can steal cards or have discard'),
        "type" => "activeplayer",
        "possibleactions" => ["takeCollection","discardCollection"],
        "transitions" => [
            "" => ST_RESOLVE_STATE
        ]
    ],
    ST_PLAYER_ATTACK => [
        'name' => 'playerAttack',
        'description' => '',
        'type' => 'game',
        'action' => 'stPlayerAttack',
        'transitions' => [],
    ],
    ST_PLAYER_DISCARD => [
        'name' => 'playerDiscard',
        'description' => '',
        'type' => 'game',
        'action' => 'stPlayerDiscard',
        'transitions' => [],
    ],
    
    ST_PLAYER_DRAW => [
        "name" => "playerDraw",
        "description" => clienttranslate('${actplayer} should draw ${numberOfCard} card(s)'),
        "descriptionmyturn" => clienttranslate('${you} should draw ${numberOfCard} card(s)'),
        "type" => "activeplayer",
        "args" => "argDrawCards",
        "action" => "stDrawCard",
        "possibleactions" => ["actDrawCards"],
        'transitions' => [
            '' => ST_START_OF_TURN,
        ],
    ],
    ST_RESOLVE_STATE => [
        'name' => 'resolveStack',
        'description' => '',
        'type' => 'game',
        'action' => 'stResolveState',
        'transitions' => [],
    ],
    // BGA framework final state. Do not modify.
    ST_SCORE_COMPUTE => [
        "name" => "comptue score",
        "description" => "",
        "type" => "game",
        "action" => "stComupteScore",
        "transitions" => [
            "" => ST_END_GAME
        ]
    ],
    ST_END_GAME => [
        'name' => 'gameEnd',
        'description' => clienttranslate('End of game'),
        'type' => 'manager',
        'action' => 'stGameEnd',
        'args' => 'argGameEnd',
    ]
];
