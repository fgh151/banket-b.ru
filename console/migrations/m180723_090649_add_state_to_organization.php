<?php

use yii\db\Migration;

/**
 * Class m180723_090649_add_state_to_organization
 */
class m180723_090649_add_state_to_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'state', $this->integer()->notNull()->defaultValue(2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organization', 'state');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180723_090649_add_state_to_organization cannot be reverted.\n";

        return false;
    }
    */
}
