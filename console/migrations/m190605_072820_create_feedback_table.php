<?php

use yii\db\Migration;

/**
 * Handles the creation of table `feedback`.
 */
class m190605_072820_create_feedback_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('feedback', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime()->notNull(),
            'user_id' => $this->integer(),
            'content' => $this->text()->notNull()
        ]);

        $this->addForeignKey(
            'feedback_user',
            'feedback',
            'user_id',
            'mobile_user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('feedback');
    }
}
