<?php

namespace Linko\Factories;

/**
 * Description of StatsFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class StatsFactory {
    public static function create(Table $table){
        $all_stats = $table->getStatTypes();
        $player_stats = $all_stats['player'];

        foreach ($player_stats as $key => $value) {
            if ($value['id'] >= 10) {
                $this->initStat('player', $key, 0);
            }
        }
        
        return $table;
    }
}
