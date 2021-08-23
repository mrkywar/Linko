<?php

namespace Linko\Serializers;

use Linko\Managers\PlayerManager;
use Linko\Models\Player;
use ReflectionClass;
use ReflectionMethod;
use stdClass;

/**
 * Description of PlayerSerializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerSerializer implements Serializer {

    //put your code here
    public function serialize(stdClass $object) {
        
    }

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
        $field = PlayerManager::FIELD_PREFIX;
        $field .= substr($methodToCall->getName(), 3);
        
        if(isset($rawDatas[$field])){
            $setter = $methodToCall->getName();
            $player->$setter($rawDatas[$field]);
        }
        
        return $this;
        
    }

    public function unserialize($rawDatas) {
        $player = new Player();

        $reflexion = new ReflectionClass(Player::class);
        $methods = $reflexion->getMethods(ReflectionMethod::IS_PUBLIC);
        $setMethods = $this->filterSetMethods($methods);

        foreach ($setMethods as $methodToCall) {
            $this->set($player, $methodToCall, $rawDatas);
        }
    }

}
