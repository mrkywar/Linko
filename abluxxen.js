/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * abluxxen implementation : © <Your name here> <Your email address here>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * abluxxen.js
 *
 * abluxxen user interface script
 * 
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

define([
    "dojo", "dojo/_base/declare",
    "ebg/core/gamegui",
    "ebg/counter",
    "ebg/stock"
],
        function (dojo, declare) {
            return declare("bgagame.abluxxen", ebg.core.gamegui, {
                constructor: function () {
                    this.debug('abluxxen constructor');

                    this.cardwidth = 87;
                    this.cardheight = 134;

                    this.numberOfNumbers = 8;
                    this.numberOfJokers = 5;
                    this.numberOfDifferentNumbers = 14;

                    this.DEBUG = true;
                    this.selectFlag = true;
                },

                /*
                 setup:
                 
                 This method must set up the game user interface according to current game situation specified
                 in parameters.
                 
                 The method is called each time the game interface is displayed to a player, ie:
                 _ when the game starts
                 _ when a player refreshes the game page (F5)
                 
                 "gamedatas" argument contains all datas retrieved by your "getAllDatas" PHP method.
                 */

                setup: function ()
                {
                    this.debug("Starting game setup");

                    // Player hand
                    this.playerHand = this.createStockForCards(this, $('myhand'));
                    dojo.connect(this.playerHand, 'onChangeSelection', this, 'onPlayerSelectionChanged');
                    // Cards in player's hand 
//                    this.debug("gamedatas", this.gamedatas);
                    this.recreateHandFromData(this.gamedatas.hand);

                    // Aviable cards in draw
                    var drawData = this.gamedatas.drawable;
                    this.drawableCard = this.createStockForCards(this, $('aviableDraw'));
                    for (var i in drawData) {
                        var card = drawData[i];
//                        this.debug("card", card);
                        this.drawableCard.addToStockWithId(card.type, card.id);
                    }
                    //dojo.connect(this.drawableCard, 'onChangeSelection', this, 'onPlayerSelectionChanged');
                    this.cardOnTable = [];
                    for (var player in this.gamedatas.players) {
//                        this.debug("p", player);
                        this.debug('Played for ' + player.toString() + "|", this.gamedatas.ontable[player.toString()]);
                        this.cardOnTable[player.toString()] = this.createStockForCards(this, $('playertable_' + player));
                        this.cardOnTable[player.toString()].setSelectionMode(0);
                        var collections = this.gamedatas.ontable[player.toString()];
                        for (var j in collections) {
                            var cards = collections[j];
                            for (var k in cards) {
                                this.cardOnTable[player.toString()].addToStockWithId(cards[k].type, cards[k].id, this.cardOnTable[player.toString()].getItemDivId(cards[k].id));
                            }

                        }

                        //this.cardOnTable[notif.args.player_id].addToStockWithId(elt.type, elt.id, this.cardOnTable[notif.args.player_id].getItemDivId(elt.id));


                    }

//                    this.test = this.createStockForCards(this, $('playertable_2351193'));

                    this.setupNotifications();

                    this.debug("Ending game setup");
                },

                ///////////////////////////////////////////////////
                //// Game & client states

                // onEnteringState: this method is called each time we are entering into a new game state.
                //                  You can use this method to perform some user interface changes at this moment.
                //
                onEnteringState: function (stateName, args)
                {
                    this.debug('Entering state: ' + stateName);

                    
                    // Hand & draw cards not selectable
                    this.playerHand.setSelectionMode(0);
                    this.drawableCard.setSelectionMode(0);

//                    
//                    this.addActionButton('completeSelection_button', _('Play cards'), 'onCompleteSelection', null, false, 'red');
//                    this.addActionButton('unselectSelection_button', _('Reset'), 'onSelectionReset', null, false, 'gray');

                    switch (stateName)
                    {

                        case 'playerTurn':
                            if (this.isCurrentPlayerActive()) {
                                // Hand cards are selectable
                                this.addActionButton('completeSelection_button', _('Play cards'), 'onCompleteSelection', null, false, 'red');
                                this.addActionButton('unselectSelection_button', _('Reset'), 'onSelectionReset', null, false, 'gray');
                                this.playerHand.setSelectionMode(2);
                            }
                            break;


                            /* Example:
                             
                             case 'myGameState':
                             
                             // Show some HTML block at this game state
                             dojo.style( 'my_html_block_id', 'display', 'block' );
                             
                             break;
                             */


                        case 'dummmy':
                            break;
                    }
                },

                // onLeavingState: this method is called each time we are leaving a game state.
                //                 You can use this method to perform some user interface changes at this moment.
                //
                onLeavingState: function (stateName)
                {
                    this.debug('Leaving state: ' + stateName);

                    this.removeActionButtons();
                    
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

                createStockForCards: function (page, element) {
                    var stock = new ebg.stock();
                    stock.create(page, element, this.cardwidth, this.cardheight);
                    stock.image_items_per_row = 1;

                    for (var cardType = 0; cardType <= this.numberOfDifferentNumbers; cardType++) {
                        stock.addItemType(cardType, cardType, g_gamethemeurl + 'img/cards.png', cardType - 1);
                    }

                    stock.onItemCreate = dojo.hitch(this, 'setupCard');
                    stock.centerItems = true;
                    stock.setSelectionAppearance('class');

                    return stock;
                },

                ///////////////////////////////////////////////////
                //// Utility methods

                /*
                 
                 Here, you can defines some utility methods that you can use everywhere in your javascript
                 script.
                 
                 */

                setupCard: function (card_div, card_type_id, card_id) {
//                    this.debug(card_div);
//                    this.debug(card_type_id);
//                    this.debug(card_id);
                },
//                moveToAnotherStock: function (item_ids, fromstock, tostock) {
//                    elt_to_remove = [];
//                    fromstock.items.forEach(function (element) {
//                        if (this.inArray(element.id, item_ids)) {
//                            elt_to_remove.push(element);
//                        }
//                    }.bind(this));
//                    elt_to_remove.forEach(
//                            function (elt) {
//                                tostock.addToStockWithId(elt.type, elt.id, fromstock.getItemDivId(elt.id));
//                                fromstock.removeFromStockById(elt.id);
//                            }.bind(this)
//                            );
//                },
                recreateHandFromData: function (handData, from) {
                    for (var i in handData) {
                        var card = handData[i];
                        this.playerHand.addToStockWithId(card.type, card.id, from);
                    }
                },
                inArray: function (needle, haystack) {
                    var length = haystack.length;
                    for (var i = 0; i < length; i++) {
                        if (haystack[i] === needle)
                            return true;
                    }
                    return false;
                },
                debug: function () {
                    if (this.DEBUG)
                        console.log.apply(null, arguments);
                },

                ///////////////////////////////////////////////////
                //// Player's action
                selectAllNumberInHand: function (targetNumber) {
                    var handItems = this.playerHand.items;
                    for (var i = 0; i < handItems.length; i++) {
                        if (handItems[i].type === targetNumber) {
                            this.playerHand.selectItem(handItems[i].id);
                        }
                    }
                },
                unselectAllNumberInHand: function (targetNumber) {
                    var handItems = this.playerHand.items;
                    for (var i = 0; i < handItems.length; i++) {
                        if (handItems[i].type === targetNumber) {
                            this.playerHand.unselectItem(handItems[i].id);
                        }
                    }
                },
                onSelectionReset: function () {
                    this.playerHand.unselectAll();
                    this.selectFlag = true;
                    this.removeActionButtons();
                },
                onPlayerSelectionChanged: function (controlName, itemId) {
                    var selectedItems = this.playerHand.getSelectedItems();

                    //this.addActionButton( 'commit_button', _('Confirm'), 'onConfirm', null, true, 'red'); 
                    if (this.selectFlag && 1 === selectedItems.length) {
                        var selectedNumber = selectedItems[0].type;

                        this.selectAllNumberInHand(selectedNumber);

                        this.selectFlag = false;
                    } else if (0 === selectedItems.length) {
                        this.selectFlag = true;
                    } else {
                        var numbers = [];
                        for (var j = 0; j < selectedItems.length; j++) {
                            if (-1 === numbers.indexOf(selectedItems[j].type) && '14' !== selectedItems[j].type) {
                                numbers.push(selectedItems[j].type);
                            }
                        }
                        this.debug("onPlayerSelectionChanged | Numbers : ", numbers);
                        if (numbers.length > 1) {
                            var selectedNumber = this.playerHand.items.filter(function (elt) {
                                return elt.id === itemId;
                            })[0].type;
                            for (var j = 0; j < selectedItems.length; j++) {
                                if ('14' !== selectedItems[j].type) {
                                    this.playerHand.unselectItem(selectedItems[j].id);
                                }
                            }
                            this.selectAllNumberInHand(selectedNumber);
                        }

                    }

                },
                onCompleteSelection: function () {
                    var selectedItems = this.playerHand.getSelectedItems();
                    var selectedIds = [];
                    for (var i = 0; i < selectedItems.length; i++) {
                        selectedIds.push(selectedItems[i].id);
                    }

                    this.selectFlag = true;
//                    this.ajaxcall("/" + this.game_name + "/" + this.game_name + "/playCards.html"
//                            this.ajaxcallwrapper('playCards', selectedIds);

                    this.ajaxcall("/" + this.game_name + "/" + this.game_name + "/playCards.html", {
                        ids: selectedIds.toString(),
                        lock: true
                    }, this, function (result) {
                        this.debug("Play :", result);
                    }, function (is_error) {
                        //--error
                        this.debug("Play fail:", is_error);
                    });

                },
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
                 console.log( 'onMyMethodToCall1' );
                 
                 // Preventing default browser reaction
                 dojo.stopEvent( evt );
                 
                 // Check that this action is possible (see "possibleactions" in states.inc.php)
                 if( ! this.checkAction( 'myAction' ) )
                 {   return; }
                 
                 this.ajaxcall( "/abluxxen/abluxxen/myAction.html", { 
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
                 your abluxxen.game.php file.
                 
                 */
                setupNotifications: function ()
                {
                    this.debug('notifications subscriptions setup');

                    // TODO: here, associate your game notifications with local methods

                    dojo.subscribe('playCards', this, "notif_cardsPlayed");
                    this.notifqueue.setSynchronous('playCards', 2500);

                    // Example 1: standard notification handling
                    // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );

                    // Example 2: standard notification handling + tell the user interface to wait
                    //            during 3 seconds after calling the method in order to let the players
                    //            see what is happening in the game.
                    // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
                    // this.notifqueue.setSynchronous( 'cardPlayed', 3000 );
                    // 
                },

                notif_cardsPlayed: function (notif) {
                    this.debug("notification CardsPlayed", notif.args);
                    if (notif.args.player_id === this.player_id) {
                        for (var i in notif.args.played_cards) {
                            var elt = notif.args.played_cards[i];
                            this.cardOnTable[notif.args.player_id].addToStockWithId(elt.type, elt.id, this.playerHand.getItemDivId(elt.id));
                            this.playerHand.removeFromStockById(elt.id);
                        }

                    } else {
                        for (var i in notif.args.played_cards) {
                            var elt = notif.args.played_cards[i];
                            this.cardOnTable[notif.args.player_id].addToStockWithId(elt.type, elt.id, this.cardOnTable[notif.args.player_id].getItemDivId(elt.id));
                        }

                    }
                }

                // TODO: from this point and below, you can write your game notifications handling methods

                /*
                 Example:
                 
                 notif_cardPlayed: function( notif )
                 {
                 console.log( 'notif_cardPlayed' );
                 console.log( notif );
                 
                 // Note: notif.args contains the arguments specified during you "notifyAllPlayers" / "notifyPlayer" PHP call
                 
                 // TODO: play the card in the user interface.
                 },    
                 
                 */
            });
        });
