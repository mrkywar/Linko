<?php

namespace Linko\Repository;

use Linko\Repository\Core\SuperRepository;

/**
 * PlayerRepository allows you to  manage the Player Model / Data link
 * Call order :
 * [DBRequester] <--> [QueryBuilder] <--> [Repository] <--> [Manager]
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class PlayerRepository extends SuperRepository {

    private CONST TABLE_NAME = "player";
    private CONST FIELDS_PREFIX = "player_";

    /* -------------------------------------------------------------------------
     *                  BEGIN - Implement SuperRepository
     * ---------------------------------------------------------------------- */

    public function getFieldsPrefix() {
        return self::FIELDS_PREFIX;
    }

    public function getTableName() {
        return self::TABLE_NAME;
    }

    /* -------------------------------------------------------------------------
     *            BEGIN - Override 
     * ---------------------------------------------------------------------- */

    public function getAll() {
        $qb = $this->getQueryBuilder()
                ->select()
                ->setFields($this->getUiFields())
                ->setKeyIndex($this->getPrimaryField())
        ;

        return $this->getDbRequester()->execute($qb);
    }

}
