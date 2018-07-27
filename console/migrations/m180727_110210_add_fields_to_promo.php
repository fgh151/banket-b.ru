<?php

use yii\db\Migration;

/**
 * Class m180727_110210_add_fields_to_promo
 */
class m180727_110210_add_fields_to_promo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('promo', 'sort', $this->integer()->notNull()->defaultValue(500));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('promo', 'sort');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180727_110210_add_fields_to_promo cannot be reverted.\n";

        return false;
    }
    */
}
