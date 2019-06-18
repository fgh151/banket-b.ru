<?php

use yii\db\Migration;

/**
 * Class m190617_132527_add_messages_to_read_message
 */
class m190617_132527_add_messages_to_read_message extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('read_message', 'user_messages', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('read_message', 'user_messages');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190617_132527_add_messages_to_read_message cannot be reverted.\n";

        return false;
    }
    */
}
