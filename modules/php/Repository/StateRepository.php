<?php

namespace Linko\Repository;

use Linko\Repository\Core\SuperRepository;

/**
 * PlayerRepository allows you to  manage the Log Model / Data link
 * Call order :
 * [DBRequester] <--> [QueryBuilder] <--> [Repository] <--> [Manager]
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class StateRepository extends SuperRepository {

    private CONST TABLE_NAME = "state";
    private CONST FIELDS_PREFIX = "state_";

    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement SuperRepository
     * ---------------------------------------------------------------------- */

    public function getFieldsPrefix() {
        return self::FIELDS_PREFIX;
    }

    public function getTableName() {
        return self::TABLE_NAME;
    }

}
