<?php

use yii\db\Migration;

class m160611_121731_product_data extends Migration
{
    public function up()
    {
        $today = date('Y-m-d 00:00:00');
        $data = [
            ['id' => 1, 'name' => 'Product 1', 'created_at' => $today, 'updated_at' => $today],
            ['id' => 2, 'name' => 'Product 2', 'created_at' => $today, 'updated_at' => $today],
        ];
        $this->batchInsert('{{%product}}', [], $data);
    }

    public function down()
    {
        $this->delete('{{%product}}', ['between', 'id', '1', '2']);
    }
}
