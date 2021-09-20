

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
                    if (null === this.selectedNumber) {
                        var cardType = ocard.target.attributes['data-type'].value;
                        this.debug("Number cardType : ", cardType);
                        this.debug("Query : ", '#myhand .card_' + cardType);
//                        this.debug("Number Null", cardType, '#myhand .card_' + cardType);
//                        this.debug("query", dojo.query('#myhand .card_' + cardType));

                        dojo.query('#myhand .card_' + cardType).addClass("selected");
                        this.selectedNumber = cardType;
                    } else {
                        this.debug("Number Not Null", ocard);
                        this.selectedNumber = null;
                    }

                    //this.debug("card click",ocard.attr('data-id'));
//                    this.debug("card click",ocard);
//                    this.debug("card className",ocard.target.className);
//                    this.debug("card datatype",ocard.target.attributes["data-type"]);

//                    dojo.removeClass(ocard.target,"selected");
//                    
//                    dojo.removeClass();


                }



            });




});
                        