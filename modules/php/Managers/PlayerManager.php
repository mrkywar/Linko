<?php

namespace Linko\Managers;

use Linko;
use Linko\Repository\PlayerRepository;
use Linko\Serializers\PlayerSerializer;
use Linko\Tools\ArrayCollection;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerManager {

    private $repository;
    /**
     * 
     * @var PlayerSerializer
     */
    private $serializer;

    public function __construct() {
        $this->repository = new PlayerRepository();
        $this->serializer = $this->repository->getSerializer();
    }

    public function getAllPlayers() {
        return $this->repository->getAll();
    }

    public function setupNewGame(array $players, array $options) {
        $playersToCreate = new ArrayCollection();

        $gameinfos = Linko::getInstance()->getGameinfos();
        $default_colors = $gameinfos['player_colors'];

        foreach ($players as $playerId => $rawPlayer) {
            $color = array_shift($default_colors);
            $player = $this->serializer->unserialize($rawPlayer);
            
            $player->setId($playerId)
                    ->setColor($color);
            $playersToCreate->add($player);
        }

        $this->repository->create($playersToCreate);

        //$this->queryBuilder->create($playersToCreate);

        Linko::getInstance()->reattributeColorsBasedOnPreferences($players, $gameinfos['player_colors']);
        Linko::getInstance()->reloadPlayersBasicInfos();
    }

}
