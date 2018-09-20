<?php

use yii\db\Migration;

/**
 * Handles the creation of table `redirect`.
 */
class m180920_134321_create_redirect_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('promo_redirect', [
            'id' => $this->primaryKey(),
            'promo_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('promo_redirect');
    }
}
