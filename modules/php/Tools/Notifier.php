<?php

namespace Linko\Tools;

use Linko\Models\Player;

/**
 * Description of Notifier
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Notifier {

    public function newHand(Player $player, $cards) {
        \Linko::getInstance()->notifyPlayer(
                $player->getId(),
                'newHand',
                '',
                array('cards' => $cards)
        );
    }

}
