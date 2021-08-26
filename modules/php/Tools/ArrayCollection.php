<?php

namespace Linko\Tools;

/**
 * Description of ArrayCollection
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class ArrayCollection extends \ArrayObject {

    public function getIds() {
        return array_keys($this->getArrayCopy());
    }

    public function getKeys() {
        return array_keys($this->getArrayCopy());
    }

    public function first() {
        $arr = $this->toArray();
        return isset($arr[0]) ? $arr[0] : null;
    }

    public function last() {
        $arr = $this->toArray();
        return (0 === sizeof($arr)) ? $arr[sizeof($arr) - 1] : null;
    }

    public function get($key) {
        $arr = $this->toArray();
        return (isset($arr[$key])) ? $arr[$key] : null;
    }

    public function toArray() {
        return array_values($this->getArrayCopy());
    }

    public function toAssoc() {
        return $this->getArrayCopy();
    }

    public function map($func) {
        return new Collection(array_map($func, $this->toAssoc()));
    }

    public function merge(ArrayCollection $arr) {
        return new Collection(array_merge($this->toAssoc(), $arr->toAssoc()));
    }

    public function reduce($func, $init) {
        return array_reduce($this->toArray(), $func, $init);
    }

    public function filter($func) {
        return new Collection(array_filter($this->toAssoc(), $func));
    }

    public function contains($value) {
        return in_array($value, $this->toArray());
    }

    public function add($elem) {
        $this->append($elem);
        return $this;
    }

}
