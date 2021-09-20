

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
                
                onHandClick: function(){
                    this.debug("Hand click");
                },
                
                onClickCard(ocard) {
                    
                    
                    //this.debug("card click",ocard.attr('data-id'));
                    this.debug("card click",ocard);
                    this.debug("card className",ocard.target.className);
                    this.debug("card datatype",ocard.target.attributes["data-type"]);
                    
                    dojo.removeClass(ocard.target,"selected");
//                    
//                    dojo.removeClass();
                    
                    
                }
                    


            });




});
                        