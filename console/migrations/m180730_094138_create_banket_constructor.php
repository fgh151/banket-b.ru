<?php

use yii\db\Migration;

/**
 * Class m180730_094138_create_banket_constructor
 */
class m180730_094138_create_banket_constructor extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('proposal', 'floristics', $this->boolean()->defaultValue(false));
        $this->addColumn('proposal', 'hall', $this->boolean()->defaultValue(false));
        $this->addColumn('proposal', 'photo', $this->boolean()->defaultValue(false));
        $this->addColumn('proposal', 'stylists', $this->boolean()->defaultValue(false));
        $this->addColumn('proposal', 'cake', $this->boolean()->defaultValue(false));
        $this->addColumn('proposal', 'entertainment', $this->boolean()->defaultValue(false));
        $this->addColumn('proposal', 'transport', $this->boolean()->defaultValue(false));
        $this->addColumn('proposal', 'present', $this->boolean()->defaultValue(false));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('proposal', 'floristics');
        $this->dropColumn('proposal', 'hall');
        $this->dropColumn('proposal', 'photo');
        $this->dropColumn('proposal', 'stylists');
        $this->dropColumn('proposal', 'cake');
        $this->dropColumn('proposal', 'entertainment');
        $this->dropColumn('proposal', 'transport');
        $this->dropColumn('proposal', 'present');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180730_094138_create_banket_constructor cannot be reverted.\n";

        return false;
    }
    */
}
