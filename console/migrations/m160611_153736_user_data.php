<?php

use yii\db\Migration;

class m160611_153736_user_data extends Migration
{
    public function up()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('{{%user}}');
        if ($tableSchema === null) {
            echo "\n";
            echo "User table is missing. Migration cannot be applied.\n";
            echo "Try to apply migrations from 'dektrium/yii2-user' module first\n";
            echo "\n";

            return false;
        }

        // add default user only on development environment
        if (YII_ENV != 'dev') {
            return;
        }

        $now = time();
        $user = [
            'id' => 1,
            'username' => 'admin',
            'email' => 'a@a.aa',
            'password_hash' => '$2y$10$/V56F4qYnPI0NY0UNkOm.OcaGRWZ1vF17DfR.bGAYlHH6poCUz..W',  // 123456
            'auth_key' => '_o1xV0_Ftxw1cyQmzyKix0o89t2oEEtk',
            'confirmed_at' => $now,
            'unconfirmed_email' => NULL,
            'blocked_at' => NULL,
            'registration_ip' => '127.0.0.1',
            'created_at' => $now,
            'updated_at' => $now,
            'flags' => 0,
        ];
        $this->insert('{{%user}}', $user);

        $profile = [
            'user_id' => 1,
            'name' => NULL,
            'public_email' => NULL,
            'gravatar_email' => NULL,
            'gravatar_id' => NULL,
            'location' => NULL,
            'website' => NULL,
            'bio' => NULL,
        ];
        $this->insert('{{%profile}}', $profile);
    }

    public function down()
    {
        // add default user only on development environment
        if (YII_ENV != 'dev') {
            return;
        }

        $this->delete('{{%profile}}', ['user_id' => 1]);
        $this->delete('{{%user}}', ['id' => 1]);
    }
}
