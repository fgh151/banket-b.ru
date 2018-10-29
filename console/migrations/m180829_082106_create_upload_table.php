<?php

use yii\db\Migration;

/**
 * Handles the creation of table `upload`.
 */
class m180829_082106_create_upload_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%upload}}', [
            'id' => $this->primaryKey(),
            'fsFileName' => $this->string()->notNull(),
            'virtualFileName' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%upload}}');
    }
}
