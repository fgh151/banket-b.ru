<?php

use yii\db\Migration;

/**
 * Class m181205_080118_create
 */
class m181205_080118_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('read_message', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'proposal_id' => $this->integer()->notNull(),
            'count' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('read_message');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181205_080118_create cannot be reverted.\n";

        return false;
    }
    */
}
