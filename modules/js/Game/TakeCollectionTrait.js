

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

                initalizeStealCollection: function (args) {
                    this.debug('stel init', args.args.actualState.state_params.targetCollection);
                    dojo.query("#"+args.args.actualState.state_params.targetCollection).addClass("selected");

                    this.addActionButton('stealCollection_button', _('Steal Collection'), 'onStealCollection', null, false, 'blue');
                    this.addActionButton('discardCollection_button', _('Discard Collection'), 'onDiscardCollection', null, false, 'red');
                },

                onStealCollection: function () {

                },

                onDiscardCollection: function () {

                }

//                initalizeTakeCollection: function () {
////                    this.debug("args", args);
//                    this.addActionButton('takeCollection_button', _('Steal Collection'), 'onStealSelection', null, false, 'red');
//                    this.addActionButton('unselectSelection_button', _('Reset'), 'onSelectionReset', null, false, 'gray');
//                }
            });




});