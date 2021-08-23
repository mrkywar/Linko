<?php

namespace Linko\Managers;

use Linko;
use Linko\Serializers\PlayerSerializer;
use Linko\Serializers\Serializer;
use Linko\Tools\Interfaces\Repository;
use Linko\Tools\QueryBuilder;

/**
 * Description of PlayerManager
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerManager implements Repository {

    const TABLE_NAME = "player";
    const FIELD_PREFIX = "player_";

    private $queryBuilder;
    private $serializer;

    public function __construct() {
        //var_dump(\Linko::getInstance()->getGameinfos());die;
        $this->queryBuilder = new QueryBuilder($this);
        $this->serializer = new PlayerSerializer();
    }

    public function getSerializer(): Serializer {
        return $this->serializer;
    }

    public function getTableName() {
        return "player";
    }

    public function initNewGame($players, $options = array()) {
        $gameinfos = Linko::getInstance()->getGameinfos();
        $default_colors = $gameinfos['player_colors'];
    }

    public function getAll() {
        return $this->queryBuilder->getAll();
    }

}
