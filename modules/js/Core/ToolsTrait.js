
/*
 * ToolsTrait is toobox can be used by any games
 * 
 */


define(['dojo', 'dojo/_base/declare', 'ebg/core/gamegui'], (dojo, declare) => {
    return declare('common.ToolsTrait', ebg.core.gamegui, {

        constructor: function () {
            this.isDebugEnabled = ('studio.boardgamearena.com' === window.location.host || window.location.hash.indexOf('debug') > -1);
        },

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