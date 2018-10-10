<?php

use yii\db\Migration;

/**
 * Handles the creation of table `restorant_params`.
 */
class m181010_074716_create_restorant_params_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('restaurant_params', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'ownAlko' => $this->boolean()->defaultValue(false),
            'scene' => $this->boolean()->defaultValue(false),
            'dance' => $this->boolean()->defaultValue(false),
            'parking' => $this->boolean()->defaultValue(false),
            'amount' => $this->double(),

        ]);

        $this->createTable('restaurant_link_cuisine', [
            'id' => $this->primaryKey(),
            'restaurant_id' => $this->integer()->notNull(),
            'cuisine_id' => $this->integer()->notNull()
        ]);

        $this->createTable('restaurant_hall', [
            'id' => $this->primaryKey(),
            'restaurant_id' => $this->integer()->notNull(),
            'title' => $this->string(),
            'size' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('restaurant_params');
        $this->dropTable('restaurant_link_cuisine');
        $this->dropTable('restaurant_hall');
    }
}
