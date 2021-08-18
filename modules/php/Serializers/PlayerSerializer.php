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
        return [
            "player_id" => $this->prepareForRow($player->getId()),
            "player_no" => $this->prepareForRow($player->getNo()),
            "player_color" => $this->prepareForRow($player->getColor()),
            "player_name" => $this->prepareForRow($player->getName()),
            "player_eliminated" => $this->prepareForRow($player->getEliminated()),
            "player_zombie" => $this->prepareForRow($player->getZombie()),
            "player_score" => $this->prepareForRow($player->getScore())
        ];
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
    }

}
