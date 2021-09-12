<?php
namespace Linko\Managers\Core;

use Linko\Managers\Manager;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
interface ManagerFactory {
    public static function create():Manager;
}
