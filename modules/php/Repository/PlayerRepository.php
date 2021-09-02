<?php

namespace Linko\Repository;

/**
 * Description of PlayerRepository
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerRepository extends Core\SuperRepository {

    private CONST TABLE_NAME = "player";
    private CONST FIELDS_PREFIX = "player_";

    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement SuperRepository
     * ---------------------------------------------------------------------- */

    public function getFieldsPrefix() {
        return self::TABLE_NAME;
    }

    public function getTableName() {
        return self::FIELDS_PREFIX;
    }

}
