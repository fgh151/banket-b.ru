<?php

use yii\db\Migration;

/**
 * Class m190313_090845_drop_email_not_null
 */
class m190313_090845_drop_email_not_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('mobile_user', 'email', 'DROP NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190313_090845_drop_email_not_null cannot be reverted.\n";

        return false;
    }
    */
}
