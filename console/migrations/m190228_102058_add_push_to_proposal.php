<?php

use yii\db\Migration;

/**
 * Class m190228_102058_add_push_to_proposal
 */
class m190228_102058_add_push_to_proposal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('proposal', 'send15', $this->boolean()->defaultValue(true));
        $this->addColumn('proposal', 'send120', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190228_102058_add_push_to_proposal cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190228_102058_add_push_to_proposal cannot be reverted.\n";

        return false;
    }
    */
}
