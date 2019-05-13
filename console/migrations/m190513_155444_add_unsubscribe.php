<?php

use yii\db\Migration;

/**
 * Class m190513_155444_add_unsubscribe
 */
class m190513_155444_add_unsubscribe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'unsubscribe', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190513_155444_add_unsubscribe cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190513_155444_add_unsubscribe cannot be reverted.\n";

        return false;
    }
    */
}
