<?php

use yii\db\Migration;

class m250124_112523_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey()->integer(),
            'chat_id' => $this->integer(11)->notNull()->unique(),
            'user_id' => $this->integer(11)->notNull()->unique(),
            'username' => $this->string(255)->null(),
            'step' => $this->string(64)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
