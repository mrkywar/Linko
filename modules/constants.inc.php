<?php

/* -------------------------------------------------------------------------
 *                  BEGIN - States 
 * ---------------------------------------------------------------------- */
define("ST_BEGIN_GAME", 1);
define("ST_END_GAME", 99);

//-- turn manager
define("ST_START_OF_TURN", 2);
define("ST_END_OF_TURN", 3);

//-- Player Action
define("ST_PLAYER_PLAY_NUMBER", 10);
define("ST_PLAYER_TAKE_COLLECTION", 11);
define("ST_PLAYER_DRAW", 12);

//-- Attack & Draw State
define("ST_PLAYER_CHOOSE", 20);
define("ST_PLAYER_ATTACK", 21);
define("ST_PLAYER_DISCARD", 22);


//-- STATE RESOLVER
define("ST_SCORE_COMPUTE", 88);
define("ST_RESOLVE_STATE", 90);

