<?php

use yii\db\Migration;

/**
 * Handles the creation of table `organization_proposal_status`.
 */
class m180723_140445_create_organization_proposal_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization_proposal_status', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'proposal_id' => $this->integer()->notNull(),
            'status' => $this->integer()
        ]);

        $this->addForeignKey('organization_proposal_status_proposal_fk', 'organization_proposal_status', 'proposal_id', 'proposal', 'id');
        $this->addForeignKey('organization_proposal_status_organization_fk', 'organization_proposal_status', 'organization_id', 'organization', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('organization_proposal_status');
    }
}
