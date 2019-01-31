<?php

use yii\db\Migration;

/**
 * Handles the creation of table `push_token`.
 */
class m190116_103800_create_push_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('push_token', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'token' => $this->string()->null(),
            'device' => $this->string(),
            'apns' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('push_token');
    }
}
