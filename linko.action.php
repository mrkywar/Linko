<?php

/**
 * ------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * Linko implementation : © <Your name here> <Your email address here>
 *
 * This code has been produced on the BGA studio platform for use on https://boardgamearena.com.
 * See http://en.doc.boardgamearena.com/Studio for more information.
 * -----
 * 
 * linko.action.php
 *
 * Linko main action entry point
 *
 *
 * In this file, you are describing all the methods that can be called from your
 * user interface logic (javascript).
 *       
 * If you define a method "myAction" here, then you can call it from your javascript code with:
 * this.ajaxcall( "/linko/linko/myAction.html", ...)
 *
 */
class action_linko extends APP_GameAction {

    // Constructor: please do not modify
    public function __default() {
        if (self::isArg('notifwindow')) {
            $this->view = "common_notifwindow";
            $this->viewArgs['table'] = self::getArg("table", AT_posint, true);
        } else {
            $this->view = "linko_linko";
            self::trace("Complete reinitialization of board game");
        }
    }

    public function playCards() {
        self::setAjaxMode();
        $cardsId = self::getArg("ids", AT_numberlist, true);

        $this->game->actionPlayCards($cardsId);
        self::ajaxResponse();
    }

    public function stealCards() {
        self::setAjaxMode();
        
        $userAction = self::getArg("useraction", AT_alphanum, true);
        
        $this->game->actionStealCards($userAction);
        self::ajaxResponse();
    }
}
