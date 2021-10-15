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
                    this.debug("Setup in trait", gamedatas);

                    //-- create players boards
                    for (var playerId in gamedatas.players) {
                        var player = gamedatas.players[playerId];
                        this.debug(player);
                        dojo.place(this.format_block('jstpl_player_board', player), 'board');
                        //-- setup player tables
//                        this.setupTables(gamedatas, playerId);
                    }

                    //-- setup pool
                    this.setupPool(gamedatas);
                    //-- setup deck & discard
                    this.setupDeck(gamedatas);

                    //-- setup player hand
                    dojo.place(this.format_block('jstpl_myhand', gamedatas.currentPlayer), 'board');

                    for (var cardId in gamedatas.hand) {
                        var card = gamedatas.hand[cardId];
                        this.handCards[card.card_id] = card;
                        var div = dojo.place(this.format_block('jstpl_card', card), 'myhand');
                        dojo.connect(div, 'onclick', (evt) => {
                            evt.preventDefault();
                            evt.stopPropagation();
                            this.onClickCard(evt);
                        });

                    }

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
//                    this.setupNotifications();
//
//                    this.debug("Ending game setup");
                },

                /**
                 *  SetupDraw : This method must set up the Draw 
                 *  
                 * @param gamedatas contains all datas retrieved by 
                 * your "getAllDatas" PHP method.        
                 */
                setupPool: function (gamedatas) {
                    this.debug(gamedatas.pool);
                    for (var cardId in gamedatas.pool) {
                        var card = gamedatas.pool[cardId];
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
                    this.debug("discard : ", gamedatas.discard);
                    var discard = {
                        last: (0 === gamedatas.discard.length) ? 'empty' : gamedatas.discard[gamedatas.discard.length - 1]["card_type"],
                        discard: gamedatas.discard.length
                    };

                    dojo.place(this.format_block('jstpl_discard', discard), 'deck');
                },

                /**
                 *  setupTables : This method must set up the table of each player
                 *  
                 * @param gamedatas contains all datas retrieved by 
                 * your "getAllDatas" PHP method.        
                 */
//                setupTables: function (gamedatas, playerId) {
//                    this.debug("setup tables for player " + playerId, gamedatas.tableInfos[playerId]);
//                    for (var collectionId in gamedatas.tableInfos[playerId]) {
//                        var collection = {
//                            collection_index: collectionId,
//                            player_id: playerId,
//                        };
//                        var div = dojo.place(this.format_block('jstpl_collection', collection), 'playertable_' + playerId);
//
//                        for (var cardId in gamedatas.tableInfos[playerId][collectionId]) {
//                            var card = gamedatas.tableInfos[playerId][collectionId][cardId];
//                            dojo.place(this.format_block('jstpl_card', card), div);
//                        }
//                    }
//
//
//
//                }

            });




});