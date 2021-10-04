<?php

namespace Linko\Serializers;

/**
 * Description of Serializer
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class Serializer {

    private const PROPERTY_COLUMN = "@ORM\Column";

    /**
     * 
     * @var string
     */
    private $classModel;

    public function __construct(string $classModel = null) {
        $this->classModel = $classModel;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Serialize & Tools
     * ---------------------------------------------------------------------- */

    public function serialize($items) {
        
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Unserialize & Tools
     * ---------------------------------------------------------------------- */

    public function unserialize($rawItems) {
        if (null === $this->classModel) {
            throw new SerializerException("No class Model defined");
        }
        $reflexion = new \ReflectionClass($this->classModel);
        foreach ($reflexion->getProperties() as $property) {
            var_dump($property->getDocComment(), $property->getName());
            die;
        }

//        var_dump($reflexion->getProperties(1)->getDocComment());
        die;

//        if (1 === sizeof($rawDatas) && !$this->isArrayForced()) {
//            $key = array_keys($rawDatas)[0];
//            return $this->unserializeOnce($rawDatas[$key], $key, $fields);
//        }
//        $objects = [];
//        foreach ($rawDatas as $key => $raw) {
//            $objects[] = $this->unserializeOnce($raw, $key, $fields);
//        }
//        return $objects;
    }

    /* -------------------------------------------------------------------------
     *                  BEGIN - Getters & Setters 
     * ---------------------------------------------------------------------- */

    public function getClassModel(): string {
        return $this->classModel;
    }

    public function setClassModel(string $classModel) {
        $this->classModel = $classModel;
        return $this;
    }

}
