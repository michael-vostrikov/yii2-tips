<?php

namespace common\components\db\mysql;

use yii\db\mysql\Schema as BaseSchema;

/**
 * @inheritdoc
 */
class Schema extends BaseSchema
{
    /**
     * @inheritdoc
     * Also gets real table name from database connection object before replacing table prefix
     */
    public function getRawTableName($name)
    {
        if (strpos($name, '{{') !== false) {
            $name = preg_replace('/\\{\\{(.*?)\\}\\}/', '\1', $name);
            $name = $this->db->getRealTableName($name);

            return $name;
        } else {
            return $name;
        }
    }
}
