<?php

use yii\db\Migration;

/**
 * Handles the creation of table `funnel`.
 */
class m190520_083941_create_funnel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('funnel', [
            'id' => $this->primaryKey(),
            'event' => $this->string()->notNull(),
            'uid' => $this->string()->notNull(),
            'user_id' => $this->integer(),
            'extra' => $this->json()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('funnel');
    }
}
