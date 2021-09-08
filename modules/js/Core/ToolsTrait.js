/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


define([
    'dojo',
    'dojo/_base/declare'
],
        (dojo, declare) => {
    return declare('linko.ToolsTrait', ebg.core.gamegui, {
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
            if (this.isDebugEnabled){
                console.log.apply(null, arguments);
            }
        }
    });
});
