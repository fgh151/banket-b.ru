<?php

use yii\db\Migration;

/**
 * Class m180809_084641_add_fields_to_mobile_users
 */
class m180809_084641_add_fields_to_mobile_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('mobile_user', 'name', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('mobile_user', 'name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180809_084641_add_fields_to_mobile_users cannot be reverted.\n";

        return false;
    }
    */
}
