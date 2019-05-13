<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cost`.
 */
class m190424_085822_create_cost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cost', [
            'id' => $this->primaryKey(),
            'restaurant_id' => $this->integer()->notNull(),
            'proposal_id' => $this->integer()->notNull(),
            'cost' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cost');
    }
}
