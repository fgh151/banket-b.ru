<?php

use yii\db\Migration;

/**
 * Class m190131_105704_remove_cuisine
 */
class m190131_105704_remove_cuisine extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('proposal', 'cuisine');
        $this->dropTable('restaurant_link_cuisine');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('proposal', 'cuisine', $this->integer());

        $this->createTable('restaurant_link_cuisine', [
            'id' => $this->primaryKey(),
            'restaurant_id' => $this->integer()->notNull(),
            'cuisine_id' => $this->integer()->notNull()
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190131_105704_remove_cuisine cannot be reverted.\n";

        return false;
    }
    */
}
