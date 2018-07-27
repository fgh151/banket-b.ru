<?php

use yii\db\Migration;

/**
 * Handles the creation of table `promo_statistic`.
 */
class m180727_111542_create_promo_statistic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('promo_statistic', [
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
        $this->dropTable('promo_statistic');
    }
}
