<?php

use yii\db\Migration;

/**
 * Class m181015_065632_add_fields_to_organization
 */
class m181015_065632_add_fields_to_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'district_id', $this->integer());
        $this->createTable('organization_link_metro', [
            'id' => $this->primaryKey(),
            'metro_id' => $this->integer()->null(),
            'organization_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181015_065632_add_fields_to_organization cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181015_065632_add_fields_to_organization cannot be reverted.\n";

        return false;
    }
    */
}
