<?php

use yii\db\Migration;

/**
 * Class m190310_090817_change_time_format
 */
class m190310_090817_change_time_format extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('proposal', 'time', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190310_090817_change_time_format cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190310_090817_change_time_format cannot be reverted.\n";

        return false;
    }
    */
}
