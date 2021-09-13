<?php

namespace Linko\Managers\Core;

/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
interface ManagerFactory {

    public static function create(Manager $manager = null): Manager;
}
