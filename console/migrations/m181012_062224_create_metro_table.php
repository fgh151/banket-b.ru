<?php

use yii\db\Migration;

/**
 * Handles the creation of table `metro`.
 */
class m181012_062224_create_metro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('metro_line', [
            'id' => $this->primaryKey(),
            'external_id' => $this->integer(),
            'city_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'color' => $this->string(),
        ]);

        $this->createTable('metro', [
            'id' => $this->primaryKey(),
            'external_id' => $this->string(),
            'line_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('metro_line');
        $this->dropTable('metro');
    }
}
