

define([
    'dojo',
    'dojo/_base/declare'
],
        (dojo, declare) => {
    return declare('linko.ToolsTrait', null, {
        /* -------------------------------------------------------------
         *                  BEGIN - DEBUG TOOL
         * ---------------------------------------------------------- */
        constructor: function () {
            this.isDebugEnabled = ('studio.boardgamearena.com' === window.location.host || window.location.hash.indexOf('debug') > -1);
        },

//        isDebugEnabled: ('studio.boardgamearena.com' === window.location.host || window.location.hash.indexOf('debug') > -1),


        /* -------------------------------------------------------------
         *                  BEGIN - DEBUG TOOL
         * ---------------------------------------------------------- */
        debug: function () {
            if (this.isDebugEnabled) {
                console.log.apply(null, arguments);
            }
        }
    });
});
