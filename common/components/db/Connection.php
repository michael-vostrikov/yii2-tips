<?php

namespace common\components\db;

use Yii;
use yii\db\Connection as BaseConnection;

/**
 * Allows to add mapping between internal table name used in application and real table name
 * Can be used to set different prefixes for tables from different modules, just to group them in DB
 */
class Connection extends BaseConnection
{
    /**
     * @var array Mapping between internal table name used in application and real table name
     * Can be used to add different prefixes for tables from different modules
     * Example: 'tableMap' => ['%session' => '%__web__session']
     */
    public $tableMap = [];


    /**
     * @inheritdoc
     */
    public function quoteSql($sql)
    {
        return preg_replace_callback(
            '/(\\{\\{(%?[\w\-\. ]+%?)\\}\\}|\\[\\[([\w\-\. ]+)\\]\\])/',
            function ($matches) {
                if (isset($matches[3])) {
                    return $this->quoteColumnName($matches[3]);
                } else {
                    return $this->getRealTableName($matches[2]);
                }
            },
            $sql
        );
    }

    /**
     * Returns real table name which is used in database
     * @param $tableName string
     * @param $useMapping bool
     */
    public function getRealTableName($tableName, $useMapping = true)
    {
        $tableName = ($useMapping && isset($this->tableMap[$tableName]) ? $this->tableMap[$tableName] : $tableName);
        $tableName = str_replace('%', $this->tablePrefix, $this->quoteTableName($tableName));

        return $tableName;
    }
}
