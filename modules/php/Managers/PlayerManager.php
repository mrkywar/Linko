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

    /* -------------------------------------------------------------------------
     *                  BEGIN - setup
     * ---------------------------------------------------------------------- */

    /**
     * Method to initalize a new Game (call one time)
     * @param array $players player to initialize
     * @param array $options
     */
    public function setupNewGame(array $players, array $options) {
        $playersToCreate = new ArrayCollection();

        $gameinfos = Linko::getInstance()->getGameinfos();
        $default_colors = $gameinfos['player_colors'];

        foreach ($players as $playerId => $rawPlayer) {
            $color = array_shift($default_colors);
            $player = $this->serializer->unserialize($rawPlayer, $this->repository->getFields());

            $player->setId($playerId)
                    ->setColor($color);
            $playersToCreate->add($player);
        }

        $this->repository->create($playersToCreate);

        //$this->queryBuilder->create($playersToCreate);

        Linko::getInstance()->reattributeColorsBasedOnPreferences($players, $gameinfos['player_colors']);
        Linko::getInstance()->reloadPlayersBasicInfos();
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Player Retriver
     * ---------------------------------------------------------------------- */

    /**
     * To got all Player in the game
     * @return type
     */
    public function getAllPlayers() {
        return $this->repository->getAll();
    }

    /**
     * To got all Player in the game for UI Dispay
     * @return type
     */
    public function getAllPlayersUi() {
        $players = $this->getAllPlayers();
        $uiFields = $this->repository->getFields();

        $result = [];
        foreach ($players as $player) {
            $result[$player->getId()] = $this->serializer->serialize($player, $uiFields);
        }
        return $result;
    }

    public function getCurrentPlayer() {
        $id = Linko::getInstance()->getCurrentPId();
        return $this->repository->getById($id);
    }

}
