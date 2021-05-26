<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%oauth_social}}`.
 */
class m210526_090544_create_oauth_social_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('oauth_social', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull()
        ]);

        $this->addForeignKey('user_social_auth_FKEY', 'oauth_social', 'user_id', 'mobile_user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('oauth_social');
    }
}
