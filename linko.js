/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * linko implementation : © <Your name here> <Your email address here>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * linko.js
 *
 * linko user interface script
 * 
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

define([
    "dojo", "dojo/_base/declare",
    "ebg/core/gamegui",
    "ebg/counter",

    g_gamethemeurl + 'modules/js/Core/ToolsTrait.js',
    g_gamethemeurl + 'modules/js/Game/SetupTrait.js',
    g_gamethemeurl + 'modules/js/Game/PlayTrait.js'//,
//    g_gamethemeurl + 'modules/js/Game/TakeCollectionTrait.js',
], function (dojo, declare) {
    return declare(
            "bgagame.linko",
//            ebg.core.gamegui,
            [
                common.ToolsTrait,
                
                linko.PlayTrait,
                linko.SetupTrait
            ],
            {
                constructor: function () {
                    this.debug('linko constructor');
                    
                    this.handCards = [];

                    // Here, you can init the global variables of your user interface
                    // Example:
                    // this.myGlobalValue = 0;

                },

                ///////////////////////////////////////////////////
                //// Game & client states

                // onEnteringState: this method is called each time we are entering into a new game state.
                //                  You can use this method to perform some user interface changes at this moment.
                //
                onEnteringState: function (stateName, args)
                {
                    this.debug('Entering state: ' + stateName);

                    switch (stateName)
                    {
                        case "playNumber":
                            if (this.isCurrentPlayerActive()) {
                                this.initalizePlayNumber();
                            }
                            break;

                            /* Example:
                             
                             case 'myGameState':
                             
                             // Show some HTML block at this game state
                             dojo.style( 'my_html_block_id', 'display', 'block' );
                             
                             break;
                             */


//                        case 'dummmy':
//                            break;
                    }
                },

                // onLeavingState: this method is called each time we are leaving a game state.
                //                 You can use this method to perform some user interface changes at this moment.
                //
                onLeavingState: function (stateName)
                {
                    this.debug('Leaving state: ' + stateName);

                    switch (stateName)
                    {

                        /* Example:
                         
                         case 'myGameState':
                         
                         // Hide the HTML block we are displaying only during this game state
                         dojo.style( 'my_html_block_id', 'display', 'none' );
                         
                         break;
                         */


                        case 'dummmy':
                            break;
                    }
                },

                // onUpdateActionButtons: in this method you can manage "action buttons" that are displayed in the
                //                        action status bar (ie: the HTML links in the status bar).
                //        
                onUpdateActionButtons: function (stateName, args)
                {
                    this.debug('onUpdateActionButtons: ' + stateName);

                    if (this.isCurrentPlayerActive())
                    {
                        switch (stateName)
                        {
                            /*               
                             Example:
                             
                             case 'myGameState':
                             
                             // Add 3 action buttons in the action status bar:
                             
                             this.addActionButton( 'button_1_id', _('Button 1 label'), 'onMyMethodToCall1' ); 
                             this.addActionButton( 'button_2_id', _('Button 2 label'), 'onMyMethodToCall2' ); 
                             this.addActionButton( 'button_3_id', _('Button 3 label'), 'onMyMethodToCall3' ); 
                             break;
                             */
                        }
                    }
                },

                ///////////////////////////////////////////////////
                //// Utility methods

                /*
                 
                 Here, you can defines some utility methods that you can use everywhere in your javascript
                 script.
                 
                 */


                ///////////////////////////////////////////////////
                //// Player's action

                /*
                 
                 Here, you are defining methods to handle player's action (ex: results of mouse click on 
                 game objects).
                 
                 Most of the time, these methods:
                 _ check the action is possible at this game state.
                 _ make a call to the game server
                 
                 */

                /* Example:
                 
                 onMyMethodToCall1: function( evt )
                 {
                 this.debug( 'onMyMethodToCall1' );
                 
                 // Preventing default browser reaction
                 dojo.stopEvent( evt );
                 
                 // Check that this action is possible (see "possibleactions" in states.inc.php)
                 if( ! this.checkAction( 'myAction' ) )
                 {   return; }
                 
                 this.ajaxcall( "/linko/linko/myAction.html", { 
                 lock: true, 
                 myArgument1: arg1, 
                 myArgument2: arg2,
                 ...
                 }, 
                 this, function( result ) {
                 
                 // What to do after the server call if it succeeded
                 // (most of the time: nothing)
                 
                 }, function( is_error) {
                 
                 // What to do after the server call in anyway (success or failure)
                 // (most of the time: nothing)
                 
                 } );        
                 },        
                 
                 */


                ///////////////////////////////////////////////////
                //// Reaction to cometD notifications

                /*
                 setupNotifications:
                 
                 In this method, you associate each of your game notifications with your local method to handle it.
                 
                 Note: game notification names correspond to "notifyAllPlayers" and "notifyPlayer" calls in
                 your linko.game.php file.
                 
                 */
                setupNotifications: function ()
                {
                    this.debug('notifications subscriptions setup');

                    // TODO: here, associate your game notifications with local methods

                    // Example 1: standard notification handling
                    // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );

                    // Example 2: standard notification handling + tell the user interface to wait
                    //            during 3 seconds after calling the method in order to let the players
                    //            see what is happening in the game.
                    // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
                    // this.notifqueue.setSynchronous( 'cardPlayed', 3000 );
                    // 
                },

                // TODO: from this point and below, you can write your game notifications handling methods

                /*
                 Example:
                 
                 notif_cardPlayed: function( notif )
                 {
                 this.debug( 'notif_cardPlayed' );
                 this.debug( notif );
                 
                 // Note: notif.args contains the arguments specified during you "notifyAllPlayers" / "notifyPlayer" PHP call
                 
                 // TODO: play the card in the user interface.
                 },    
                 
                 */
            });
});
