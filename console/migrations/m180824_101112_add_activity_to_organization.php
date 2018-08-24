<?php

use yii\db\Migration;

/**
 * Class m180824_101112_add_activity_to_organization
 */
class m180824_101112_add_activity_to_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('activity', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()
        ]);

        $this->createTable('organization_link_activity', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'activity_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('activity');
        $this->dropTable('organization_link_activity');
    }


}
