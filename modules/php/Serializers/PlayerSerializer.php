<?php

namespace Linko\Serializers;

use Linko\Models\Player;

/**
 * Description of Player
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerSerializer extends Serializer {

    public function serialize(Player $player) {

        //-- TODO kywar
        throw new BgaUserException(self::_("Not yet developped"));
    }


    public function unserialize($row) {

        $player = new Player();

        $player->setId($this->extractFromRow($row, 'player_id', self::INTEGER_FORMAT))
                ->setNo($this->extractFromRow($row, 'player_no', self::INTEGER_FORMAT))
                ->setName($this->extractFromRow($row, 'player_name', self::STRING_FORMAT))
                ->setColor($this->extractFromRow($row, 'player_color', self::STRING_FORMAT))
                ->setEliminated($this->extractFromRow($row, 'player_eliminated', self::BOOLEAN_FORMAT))
                ->setZombie($this->extractFromRow($row, 'player_zombie', self::BOOLEAN_FORMAT))
                ->setScore($this->extractFromRow($row, 'player_score', self::INTEGER_FORMAT));
        
        return $player;
//        $player->setColor($color)
//                 $this->id = (int) $row['player_id'];
//      $this->no = (int) $row['player_no'];
//      $this->name = $row['player_name'];
//      $this->color = $row['player_color'];
//      $this->eliminated = $row['player_eliminated'] == 1;
//      $this->hp = (int) $row['player_hp'];
//      $this->zombie = $row['player_zombie'] == 1;
//      $this->role = $row['player_role'];
//      $this->bullets = (int) $row['player_bullets'];
//      $this->score = (int) $row['player_score'];
//      $this->generalStore = (int) $row['player_autopick_general_store'];
    }

}
