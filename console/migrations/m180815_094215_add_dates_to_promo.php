<?php

use yii\db\Migration;

/**
 * Class m180815_094215_add_dates_to_promo
 */
class m180815_094215_add_dates_to_promo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('promo', 'start', $this->date());
        $this->addColumn('promo', 'end', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180815_094215_add_dates_to_promo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180815_094215_add_dates_to_promo cannot be reverted.\n";

        return false;
    }
    */
}
