

define([
    'dojo',
    'dojo/_base/declare',
    'ebg/core/gamegui',

    g_gamethemeurl + 'modules/js/Core/ToolsTrait.js'
], function (dojo, declare) {
    return declare(
            'linko.PlayTrait',
            [
                common.ToolsTrait
            ],
            {

                constructor: function () {
                    this.debug('linko.playTrait constructor');
                },

                initalizePlayNumber: function () {
                    this.addActionButton('completeSelection_button', _('Play cards'), 'onCompleteSelection', null, false, 'red');
                    this.addActionButton('unselectSelection_button', _('Reset'), 'onSelectionReset', null, false, 'gray');

                    dojo.query("#myhand .cardontable").addClass("selectable");
                    dojo.connect("#myhand .cardontable", 'onHandClick', (evt) => {
                        evt.preventDefault();
                        evt.stopPropagation();
                        this.onClickCard(this);
                    });

                },

                /* -------------------------------------------------------------
                 *                  BEGIN - Btn Actions
                 * ---------------------------------------------------------- */

                onSelectionReset: function () {
                    dojo.query('#myhand .selected').removeClass("selected");
                    this.selectedJokers = [];
                    this.selectedNumber = null;
                },

                onCompleteSelection: function () {
                    var cards = dojo.query('#myhand .selected').map((card) => {
                        return dojo.attr(card, 'data-id');
                    });
                    this.debug('cards : ', cards);
                    this.ajaxcall("/" + this.game_name + "/" + this.game_name + "/playCards.html", {
                        ids: cards.toString(),
                        lock: true
                    }, this, function (result) {
                        this.debug("Play :", result);
                    }, function (is_error) {
                        //--error
                        this.debug("Play fail:", is_error);
                    });
                    
                },

                onHandClick: function () {
                    this.debug("Hand click");
                },

                getCardInHand: function (targetedCard) {
                    var cardId = targetedCard.target.attributes['data-id'].value;
                    return this.handCards[cardId];
                },

                onClickCard(targetedCard) {
                    var card = this.getCardInHand(targetedCard);
                    var cardType = card.card_type;
                    if ("14" === cardType) {
                        var pos = this.selectedJokers.indexOf(card.card_id);
                        if (pos >= 0) {
                            dojo.query('#myhand #linko_card_' + card.card_id).removeClass("selected");
                            this.selectedJokers.splice(pos, 1);
                        } else {
                            dojo.query('#myhand #linko_card_' + card.card_id).addClass("selected");
                            this.selectedJokers.push(card.card_id);
                        }
                    } else if (null === this.selectedNumber) {
                        dojo.query('#myhand .card_' + cardType).addClass("selected");
                        this.selectedNumber = cardType;
                    } else if (this.selectedNumber !== cardType) {
                        dojo.query('#myhand .card_' + this.selectedNumber).removeClass("selected");
                        dojo.query('#myhand .card_' + cardType).addClass("selected");
                        this.selectedNumber = cardType;
                    } else {
                        if (targetedCard.target.attributes['class'].value.indexOf("selected") > 0) {
                            dojo.query('#myhand #linko_card_' + card.card_id).removeClass("selected");
                        } else {
                            dojo.query('#myhand #linko_card_' + card.card_id).addClass("selected");
                        }

                    }

                }

            });




});
                        