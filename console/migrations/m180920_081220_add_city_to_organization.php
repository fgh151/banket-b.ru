<?php

use yii\db\Migration;

/**
 * Class m180920_081220_add_city_to_organization
 */
class m180920_081220_add_city_to_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'city_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organization', 'city_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180920_081220_add_city_to_organization cannot be reverted.\n";

        return false;
    }
    */
}
