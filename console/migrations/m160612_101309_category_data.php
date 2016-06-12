<?php

use yii\db\Migration;

class m160612_101309_category_data extends Migration
{
    public function up()
    {
        $data = [
            ['id' => 1, 'name' => 'Category 1'],
            ['id' => 2, 'name' => 'Category 2'],
        ];
        $this->batchInsert('{{%category}}', [], $data);
    }

    public function down()
    {
        $this->delete('{{%category}}', ['between', 'id', '1', '2']);
    }
}
