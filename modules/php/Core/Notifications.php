<?php

namespace Linko\Core;

use Linko;

/*
 * Notifications
 */

abstract class Notifications {
    /* --------------------------------
     *  BEGIN Prncipals methods (not public)
     * --------------------------------
     */

    protected static function notifyAll($name, $msg, $data) {
        self::updateArgs($data);
        Linko::getInstance()->notifyAllPlayers($name, $msg, $data);
    }

    protected static function notify($pId, $name, $msg, $data) {
        self::updateArgs($data);
        $playerId = is_int($pId) ? $pId : $pId->getId();
        Linko::getInstance()->notifyPlayer($playerId, $name, $msg, $data);
    }

    public static function updateHand($player) {
        self::notifyAll('updateHand', '', [
            'player' => $player,
            'total' => $player->getHand()->count(),
        ]);
    }

    /* --------------------------------
     *  END Prncipals methods (not public)
     * --------------------------------
     */


    /* --------------------------------
     *  BEGIN public methods (shortcuts)
     * --------------------------------
     */

    public static function newHand(Player $player, $cards) {
        self::notify($player, 'newHand', '', array('cards' => $cards));
    }

    public static function showMessage($playerId, $message) {
        self::notify($playerId, 'showMessage', $message, []);
    }

//    public static function reshuffle() {
//        self::notifyAll('reshuffle', clienttranslate('Reshuffling the deck.'), [
//            'deckCount' => Cards::getDeckCount(),
//        ]);
//    }

    /* --------------------------------
     *  BEGIN public methods (shortcuts)
     * --------------------------------
     */

    public static function updateArgs(&$data) {
        if (isset($data['player'])) {
            $data['player_id'] = $data['player']->getId();
            $data['player_name'] = $data['player']->getName();
            unset($data['player']);
        }

        if (isset($data['player2'])) {
            $data['player_id2'] = $data['player2']->getId();
            $data['player_name2'] = $data['player2']->getName();
            unset($data['player2']);
        }

        if (isset($data['card'])) {
            $data['card_name'] = $data['card']->getName();
            $data['i18n'][] = 'card_name';
            $data['preserve'][2] = $data['card'];
        }

        if (isset($data['ignore'])) {
            $data['preserve'][3] = 'ignore';
            $data['ignore'] = array_map(function ($player) {
                return $player->getId();
            }, $data['ignore']);
        }

        if (isset($data['msgYou'])) {
            $data['preserve'][4] = 'msgYou';
        }
    }

}
