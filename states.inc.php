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
    
    ST_RESOLVE_STATE => [
        'name' => 'resolveStack',
        'description' => '',
        'type' => 'game',
        'action' => 'stResolveState',
        'transitions' => [],
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



