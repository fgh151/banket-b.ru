<?php

use yii\db\Migration;

/**
 * Class m190522_120512_add_proposal_search_field
 */
class m190522_120512_add_proposal_search_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'proposal_search', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organization', 'proposal_search');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190522_120512_add_proposal_search_field cannot be reverted.\n";

        return false;
    }
    */
}
