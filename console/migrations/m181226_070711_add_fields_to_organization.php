<?php

use yii\db\Migration;

/**
 * Class m181226_070711_add_fields_to_organization
 */
class m181226_070711_add_fields_to_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'restogram_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181226_070711_add_fields_to_organization cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181226_070711_add_fields_to_organization cannot be reverted.\n";

        return false;
    }
    */
}
