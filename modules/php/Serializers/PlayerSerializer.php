<?php

namespace Linko\Serializers;

use Linko\Models\Model;
use Linko\Models\Player;
use Linko\Repository\PlayerRepository;
use ReflectionClass;
use ReflectionMethod;

/**
 * Description of PlayerSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerSerializer implements Serializer {
    
    
    /**
     * Object To Array 
     * @param Model $object
     * @return array $rawDatas
     */

    public function serialize(Model $object, array $fields) {
        $raw = [];

        foreach ($fields as $field) {
            $getter = "get" . ucfirst($field);
            $raw[$field] = $object->$getter();
        }

        return $raw;
    }

    
    /* -------------------------------------------------------------------------
     *                  BEGIN -  Unserialize Methods
     * ---------------------------------------------------------------------- */
    
    private function isSetMethod(ReflectionMethod $method) {
        return("set" === substr($method->getName(), 0, 3));
    }

    private function filterSetMethods(array $methods) {
        $filteredMethods = [];
        foreach ($methods as $method) {
            if ($this->isSetMethod($method)) {
                $filteredMethods[] = $method;
            }
        }
        return $filteredMethods;
    }

    private function set(Player &$player, ReflectionMethod $methodToCall, $rawDatas) {
        $field = PlayerRepository::FIELDS_PREFIX;
        $field .= strtolower(substr($methodToCall->getName(), 3));

        if (isset($rawDatas[strtolower($field)])) {
            $setter = $methodToCall->getName();
            $player->$setter($rawDatas[$field]);
        }

        return $this;
    }

    /**
     * Array To Object
     * @param array $rawDatas
     * @return Player
     */
    public function unserialize($rawDatas) {
        $player = new Player();

        $reflexion = new ReflectionClass(Player::class);
        $methods = $reflexion->getMethods(ReflectionMethod::IS_PUBLIC);
        $setMethods = $this->filterSetMethods($methods);

        foreach ($setMethods as $methodToCall) {
            $this->set($player, $methodToCall, $rawDatas);
        }

        return $player;
    }

}
