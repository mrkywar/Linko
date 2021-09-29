

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

                initalizeStealCollection: function () {
                    this.debug('stel init');
                }
//                initalizeTakeCollection: function () {
////                    this.debug("args", args);
//                    this.addActionButton('takeCollection_button', _('Steal Collection'), 'onStealSelection', null, false, 'red');
//                    this.addActionButton('unselectSelection_button', _('Reset'), 'onSelectionReset', null, false, 'gray');
//                }
            });




});