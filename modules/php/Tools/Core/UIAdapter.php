<?php

namespace Linko\Tools\Core;

use Linko\Repository\Core\Repository;

/**
 * UIAdapter keep only displayable fields 
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class UIAdapter {

    /**
     * keep displayable field for a uniq data result
     * @param Repository $repo
     * @param array $data data reult
     * @return array : UI datas
     */
    static public function adaptOnce(Repository $repo, $data) {
        $result = [];
        foreach ($repo->getUIFields() as $field) {
            $result[$field->getDB()] = $data[$field->getDB()];
        }
        return $result;
    }

    /**
     * keep displayable field for a multiple data result
     * @param Repository $repo
     * @param array $datas data reults
     * @return array : UI datas
     */
    static public function adapt(Repository $repo, $datas) {
        $results = [];
        foreach ($datas as $key => $data) {
            $results[$key] = self::adaptOnce($repo, $data);
        }


        return $results;
    }

}
