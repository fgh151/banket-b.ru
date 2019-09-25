<?php

use yii\db\Migration;

/**
 * Class m190826_181359_add_phone_to_organization
 */
class m190826_181359_add_phone_to_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'organization_phone', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organization', 'organization_phone');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190826_181359_add_phone_to_organization cannot be reverted.\n";

        return false;
    }
    */
}
