<?php

use yii\db\Migration;

/**
 * Handles the creation of table `promo`.
 */
class m180727_052906_create_promo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('promo', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'image' => $this->string()->notNull(),
            'link' => $this->string(),
            'start' => $this->date(),
            'end' => $this->date()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('promo');
    }
}
