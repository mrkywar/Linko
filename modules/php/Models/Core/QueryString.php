<?php

namespace Linko\Models\Core;

/**
 * Description of QueryString
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class QueryString {

    const TYPE_SELECT = "SELECT";
    const TYPE_INSERT = "INSERT";
    const TYPE_UPDATE = "UPDATE";
    const TYPE_CUSTOM = "CUSTOM";
    
    const ORDER_ASC = "ASC";
    const ORDER_DESC = "DESC";
}
