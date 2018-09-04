<?php

use yii\db\Migration;

/**
 * Class m180904_084710_add_pay_to_organization
 */
class m180904_084710_add_pay_to_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'state_promo',  $this->integer());
        $this->addColumn('organization', 'state_statistic',  $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organization', 'state_promo');
        $this->dropColumn('organization', 'state_statistic');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180904_084710_add_pay_to_organization cannot be reverted.\n";

        return false;
    }
    */
}
