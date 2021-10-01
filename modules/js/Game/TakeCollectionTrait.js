

define([
    'dojo',
    'dojo/_base/declare',
    'ebg/core/gamegui',

    g_gamethemeurl + 'modules/js/Core/ToolsTrait.js'
], function (dojo, declare) {
    return declare(
            'linko.TakeCollectionTrait',
            [
                common.ToolsTrait
            ],
            {

                constructor: function () {
                    this.debug('linko.TakeCollectionTrait constructor');
                },

                /* -------------------------------------------------------------
                 *                  BEGIN - Btn Actions
                 * ---------------------------------------------------------- */

                initalizeStealCards: function (args) {
                    this.debug('stel init', args.args.actualState.state_params.targetCollection);
                    dojo.query("#" + args.args.actualState.state_params.targetCollection).addClass("selected");

                    this.addActionButton('stealCard_button', _('Steal Cards'), 'onStealCard', null, false, 'blue');
                    this.addActionButton('discardCard_button', _('Discard Cards'), 'onDiscardCard', null, false, 'red');
                },

                onStealCard: function () {
                    this.ajaxcall("/" + this.game_name + "/" + this.game_name + "/stealCards.html", {
                        lock: true,
                        useraction: 'steal'
                    }, this, function (result) {
                        this.debug("Discard Card :", result);
                    }, function (is_error) {
                        //--error
                        this.debug("Play fail:", is_error);
                    });
                },

                onDiscardCard: function () {
                    this.ajaxcall("/" + this.game_name + "/" + this.game_name + "/stealCards.html", {
                        lock: true,
                        useraction: 'discard'
                    }, this, function (result) {
                        this.debug("Discard Card :", result);
                    }, function (is_error) {
                        //--error
                        this.debug("Play fail:", is_error);
                    });
                },

                /* -------------------------------------------------------------
                 *                  BEGIN - Notifications
                 * ---------------------------------------------------------- */

                notifStealCard: function (datas) {
                    this.debug('NSC', datas.args);
                    for (var cardId in datas.args.cards) {
                        var card = datas.args.cards[cardId];

                        var divId = card.card_location + "_card_" + card.card_id;
                        if (parseInt(datas.args.playerId) === this.player_id) {
                            this.slideToObjectAndDestroy(divId, "myhand");
                            dojo.place(this.format_block('jstpl_card', card), "myhand");
                        } else {
                            this.debug("NSC - NOT IMPLENTED PART");
                        }

                    }
                },

                notifDiscardCard: function (datas) {
                    this.debug('NDC', datas.args);
                    for (var cardId in datas.args.cards) {
                        var card = datas.args.cards[cardId];

                        var divId = card.card_location + "_card_" + card.card_id;
                        this.slideToObjectAndDestroy(divId, "discard");

                        dojo.query("#discard").removeClass('card_empty card_1 card_2 card_3 card_4 card_5 card_6 card_7 card_8 card_9 card_10 card_11 card_12 card_13 card_14')
                                .addClass('card_' + card.card_type);
                    }

                    var divCount = dojo.query("#discard .count-status");
                    var newVal = parseInt(divCount.innerHTML()) + datas.args.cards.length;

                    divCount.innerHTML(newVal);
                }

            });




});