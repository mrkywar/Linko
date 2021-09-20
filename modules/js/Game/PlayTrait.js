

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

                },

                onCompleteSelection: function () {

                },

                onHandClick: function () {
                    this.debug("Hand click");
                },

                onClickCard(ocard) {
                    var cardType = ocard.target.attributes['data-type'].value;
//                    dojo.query('#myhand .card_' + cardType).removeClass("selected");
                    if (null === this.selectedNumber) {
                        this.debug("New Number cardType : ", cardType);
                        dojo.query('#myhand .card_' + cardType).addClass("selected");
                        this.selectedNumber = cardType;
                    } else if ("14" === cardType) {
                        this.debug("Joker selected", ocard);
                        dojo.query('#myhand .card_' + cardType).addClass("selected");
                    } else if (this.selectedNumber !== cardType) {
                        this.debug("Change Number cardType : ", cardType);
                        dojo.query('#myhand .card_' + this.selectedNumber).removeClass("selected");
                        dojo.query('#myhand .card_' + cardType).addClass("selected");
                        this.selectedNumber = cardType;
                    }
                }

            });




});
                        