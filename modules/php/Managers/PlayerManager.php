<?php

namespace Linko\Managers;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerManager extends Manager {

    public function initNewGame($player = null, $options = null) {
        $gameinfo = \Linko::getInstance()->getGameinfos();

        var_dump($gameinfo);
        die;
    }

}
