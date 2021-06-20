<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_image}}`.
 */
class m210618_091012_create_blog_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('blog_image', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer()->notNull(),
            'upload_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('blog_image');
    }
}
