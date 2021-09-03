<?php

namespace Linko\Game;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
trait PlayCardsTrait {

    public function playCards($cardsId) {
        \Linko::getInstance()->checkAction("playCards");
        //$player = Link
    }

    public function stPlayCard() {
        /*
          // TODO: Do we need this?
          $players = Players::getLivingPlayers(null, true);
          $newstate = null;
          foreach($players as $player) {
          $player->checkHand();
          }
          if($newstate != null) $this->gamestate->nextState($newState);
         */
//        $player = Players::getActive();
//        if ($player->getHand()->count() == 0) {
//            Notifications::tell(clienttranslate('${player_name} does not have any cards in hand and thus ends their turn'), [
//                'player_name' => $player->getName(),
//            ]);
//            Stack::unsuspendNext(ST_PLAY_CARD);
//            Stack::finishState();
//        }
        die("unimplemented");
    }

}

//public function playCards($cardsIds) {
//        //var_dump( self::checkAction("playCards",false));die;
//        self::checkAction("playCards");
//        $player_id = self::getActivePlayerId();
//
//        $actionInfos = $this->getPlayedCardsInfos($cardsIds, $player_id);
//
//        $posArg = self::getStat("sequence_count", $player_id);
//        $this->cards->moveCards($actionInfos['selectedIds'], "playertablecard_" . $player_id, $posArg + 1);
//
//        //-- Update stats
//        $this->updPlayStats($actionInfos, $player_id);
//
//        // And notify
//        self::notifyAllPlayers('playCards', clienttranslate('${player_name} play a serie of $(count_displayed) cards of value $(value_displayed)'), array(
//            'i18n' => array(),
//            'played_cards' => $actionInfos['selectedCards'],
//            'player_id' => intval($player_id),
//            'player_name' => self::getActivePlayerName(),
//            'value' => $actionInfos['value'],
//            'value_displayed' => $actionInfos['value'],
//            'count_displayed' => sizeof($actionInfos['selectedCards'])
//        ));
//
//        $this->takeableCollection = $this->getTakeableCollections($actionInfos, $player_id);
//        $remindedCards = $this->cards->getPlayerHand($player_id);
//        if (sizeof($this->takeableCollection)) {
//
//            $this->autoTakeCollection($player_id);
//            // TODO - Kyw : Tempory desactivated for dev rest
//            //$this->gamestate->nextState("takeCollection");
//        } elseif (sizeof($remindedCards) > 0) {
//            $this->gamestate->nextState("nextPlayer");
//        } else {
//            $this->gamestate->nextState("getFinalScores");
//        }
//    }
