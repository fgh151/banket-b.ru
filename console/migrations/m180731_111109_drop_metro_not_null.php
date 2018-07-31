<?php

use yii\db\Migration;

/**
 * Class m180731_111109_drop_metro_not_null
 */
class m180731_111109_drop_metro_not_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('proposal', 'metro');
        $this->addColumn('proposal', 'metro', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180731_111109_drop_metro_not_null cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180731_111109_drop_metro_not_null cannot be reverted.\n";

        return false;
    }
    */
}
