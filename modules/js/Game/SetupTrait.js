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
        
    return declare('linko.SetupTrait', null, {
        /* -------------------------------------------------------------
         *                  BEGIN - DEBUG TOOL
         * ---------------------------------------------------------- */
        constructor: function () {
            console.log('ok');
//            this.isDebugEnabled = ('studio.boardgamearena.com' === window.location.host || window.location.hash.indexOf('debug') > -1);
        },

//        isDebugEnabled: ('studio.boardgamearena.com' === window.location.host || window.location.hash.indexOf('debug') > -1),


        /* -------------------------------------------------------------
         *                  BEGIN - DEBUG TOOL
         * ---------------------------------------------------------- */
        setupT: function () {
            console.log('ok');
        }
    });
});
