<?php

use yii\db\Migration;

class m160612_094401_product_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%product}}',
            'user_id', $this->integer()->after('id')
        );

        $this->addForeignKey('fk_product_user', '{{%product}}', 'user_id', '{{%user}}', 'id');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');

        $this->dropForeignKey('fk_product_user', '{{%product}}');
        $this->dropColumn('{{%product}}', 'user_id');

        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
