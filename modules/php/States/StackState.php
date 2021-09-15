<?php

namespace Linko\States;

use Linko\Managers\GlobalVarManager;
use Linko\Models\GlobalVar;

/**
 * Description of StackState
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class StackState {

    /**
     * @var array<State>
     */
    private $states;

    public function __construct() {
       
    }
    
//    private function retriveStack() {
//        $stack = GlobalVarManager::getVar(GlobalVar::STACK_STATE);
//        if (null !== $stack) {
//            $this->states = json_decode($stack->getValue());
//        }else{
//            $state = ne
//        }
//    }

    public function getStates() {
        return $this->states;
    }

    public function addState(State $state) {
        $this->states[] = $state;

        return $this;
    }

    public function getFirstState() {
        if (isset($this->states[0])) {
            return $this->states[0];
        }
        return;
    }

    public function getNextState() {
        if (isset($this->states[1])) {
            return $this->states[1];
        }
        return;
    }

    private function getStateKey(State $sState) {
        foreach ($this->states as $key => $state) {
            if ($state->getId() === $sState->getId()) {
                return $key;
            }
        }
        return;
    }

    public function suspendState(State $sState, $suspend = true) {
        $key = $this->getStateKey($sState);
        if (null !== $key) {
            $this->states[$key]->setIsSupended($suspend);
        }
        return $this;
    }

    public function persist() {
        $jsonVal = json_encode($this->states);
        GlobalVarManager::setVar(GlobalVar::STACK_STATE, $jsonVal);
        return $this;
    }

}
