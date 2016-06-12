<?php

use yii\db\Migration;

class m160612_100107_product_category extends Migration
{
    public function up()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
        ]);

        $this->addColumn('{{%product}}',
            'category_id', $this->integer()->after('user_id')
        );

        $this->addForeignKey('fk_product_category', '{{%product}}', 'category_id', '{{%category}}', 'id');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');

        $this->dropForeignKey('fk_product_category', '{{%product}}');
        $this->dropColumn('{{%product}}', 'category_id');
        $this->dropTable('{{%category}}');

        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
