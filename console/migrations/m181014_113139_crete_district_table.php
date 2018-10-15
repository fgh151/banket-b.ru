<?php

use yii\db\Migration;

/**
 * Class m181014_113139_crete_district_table
 */
class m181014_113139_crete_district_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('district', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer()->null(),
            'title' => $this->string()->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181014_113139_crete_district_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181014_113139_crete_district_table cannot be reverted.\n";

        return false;
    }
    */
}
