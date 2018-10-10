<?php

use yii\db\Migration;

/**
 * Class m181010_074020_pay_for_direct_proposals
 */
class m181010_074020_pay_for_direct_proposals extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'state_direct', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181010_074020_pay_for_direct_proposals cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181010_074020_pay_for_direct_proposals cannot be reverted.\n";

        return false;
    }
    */
}
