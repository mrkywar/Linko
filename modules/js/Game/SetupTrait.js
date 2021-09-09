/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


define([
    'dojo',
    'dojo/_base/declare',
    'ebg/core/gamegui',

    g_gamethemeurl + 'modules/js/Core/ToolsTrait.js'
], function (dojo, declare) {
    return declare(
            'linko.SetupTrait',
            [
                common.ToolsTrait
            ],
            {

                constructor: function () {
                    this.debug('linko.setupTrait constructor');
                },

                /* -------------------------------------------------------------
                 *                  BEGIN - Setup Game
                 * ---------------------------------------------------------- */
                /**
                 *  Setup : This method must set up the game user interface
                 *          according to current game situation specified in 
                 *          parameters. 
                 *  
                 *  The method is called each time the game interface is 
                 *  displayed to a player, ie:  
                 *  - when the game starts                              
                 *  - when a player refreshes the game page (F5)
                 *  
                 * @param gamedatas contains all datas retrieved by 
                 * your "getAllDatas" PHP method.     
                 */

                setup: function (gamedatas)
                {
                    this.debug("Starting game setup");
                    this.debug("Gamedata : ", gamedatas);

//                    // Setting up player boards
//                    for (var player_id in gamedatas.players)
//                    {
//                        var player = gamedatas.players[player_id];
//
//                        // TODO: Setting up players boards if needed
//                    }
//
//                    // TODO: Set up your game interface here, according to "gamedatas"
//
//
//                    // Setup game notifications to handle (see "setupNotifications" method below)
                    this.setupNotifications();

                    this.debug("Ending game setup");
                }
            });
});