<?php

use yii\db\Migration;
use yii\db\pgsql\Schema;
/**
 * Class m181009_113208_add_organizations_to_proposal
 */
class m181009_113208_add_organizations_to_proposal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('proposal', 'organizations', Schema::TYPE_JSONB);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181009_113208_add_organizations_to_proposal cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181009_113208_add_organizations_to_proposal cannot be reverted.\n";

        return false;
    }
    */
}
