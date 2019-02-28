<?php

use yii\db\Migration;

/**
 * Class m190213_121011_add_rating
 */
class m190213_121011_add_rating extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'rating', $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organization', 'rating');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190213_121011_add_rating cannot be reverted.\n";

        return false;
    }
    */
}
