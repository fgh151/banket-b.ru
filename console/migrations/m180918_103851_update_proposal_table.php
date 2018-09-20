<?php

use yii\db\Migration;

/**
 * Class m180918_103851_update_proposal_table
 */
class m180918_103851_update_proposal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('proposal', 'City', $this->string());

        $this->addColumn('proposal', 'city_id', $this->integer());
        $this->addColumn('proposal', 'region_id', $this->integer());
        $this->addColumn('proposal', 'all_regions', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('proposal', 'region_id');
        $this->dropColumn('proposal', 'city_id');
        $this->dropColumn('proposal', 'all_regions');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180918_103851_update_proposal_table cannot be reverted.\n";

        return false;
    }
    */
}
