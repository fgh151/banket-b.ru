<?php

use yii\db\Migration;

/**
 * Class m190310_131010_drop_proposal_type
 */
class m190310_131010_drop_proposal_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('proposal', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190310_131010_drop_proposal_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190310_131010_drop_proposal_type cannot be reverted.\n";

        return false;
    }
    */
}
