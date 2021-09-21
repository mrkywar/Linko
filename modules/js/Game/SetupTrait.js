

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

                    //-- create players boards
                    for (var playerId in gamedatas.players) {
                        var player = gamedatas.players[playerId];
                        dojo.place(this.format_block('jstpl_player_board', player), 'board');
                    }

                    //-- setup draw
                    this.setupDraw(gamedatas);
                    //-- setup deck & discard
                    this.setupDeck(gamedatas);

                    //-- setup player hand
                    dojo.place(this.format_block('jstpl_myhand', null), 'board');
                    for (var cardId in gamedatas.hand) {
                        var card = gamedatas.hand[cardId];
                        this.handCards[card.card_id] = card;
                        var div = dojo.place(this.format_block('jstpl_card', card), 'myhand');
                        dojo.connect(div,'onclick', (evt) => {
                            evt.preventDefault();
                            evt.stopPropagation();
                            this.onClickCard(evt);
                        });
                       
                    }

                    // Setup game notifications to handle (see "setupNotifications" method below)
                    this.setupNotifications();

                    this.debug("Ending game setup");
                },

                /**
                 *  SetupDraw : This method must set up the Draw 
                 *  
                 * @param gamedatas contains all datas retrieved by 
                 * your "getAllDatas" PHP method.        
                 */

                setupDraw: function (gamedatas) {
                    for (var cardId in gamedatas.draw) {
                        var card = gamedatas.draw[cardId];
                        var div = dojo.place(this.format_block('jstpl_card', card), 'aviableDraw');
                        dojo.connect(div, 'onclick', (evt) => {
                            evt.preventDefault();
                            evt.stopPropagation();
                            this.onClickCard(card);
                        });
                    }
                },

                /**
                 *  SetupDraw : This method must set up the Deck and Discard 
                 *  
                 * @param gamedatas contains all datas retrieved by 
                 * your "getAllDatas" PHP method.        
                 */
                setupDeck: function (gamedatas) {
                    //-- setup deck
                    var deck = {
                        deck: gamedatas.deck
                    };
                    dojo.place(this.format_block('jstpl_deck', deck), 'deck');

                    //-- setup discard
                    var discard = {
                        last: (null === gamedatas.discard) ? 'empty' : gamedatas.discard[gamedatas.discard.length - 1]["card_type"],
                        discard: (null === gamedatas.discard) ? 0 : gamedatas.discard.length
                    };
                    dojo.place(this.format_block('jstpl_discard', discard), 'deck');
                }

            });




});