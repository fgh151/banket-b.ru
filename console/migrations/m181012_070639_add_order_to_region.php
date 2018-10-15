<?php

use yii\db\Migration;

/**
 * Class m181012_070639_add_order_to_region
 */
class m181012_070639_add_order_to_region extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('geo_region', 'order', $this->integer()->defaultValue(500));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181012_070639_add_order_to_region cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181012_070639_add_order_to_region cannot be reverted.\n";

        return false;
    }
    */
}
