<?php
namespace Linko\Managers\Factories;

use Linko\Managers\PlayerManager;
/**
 * Description of PlayerManagerFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class PlayerManagerFactory {
    public static function create() {
        $manager = new PlayerManager();
        
        
        
        return $manager;
    }
    
}
