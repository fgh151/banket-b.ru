<?php

use yii\db\Migration;

/**
 * Handles the creation of table `known_proposals`.
 */
class m190617_121308_create_known_proposals_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('known_proposal', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'proposal_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('known_proposal');
    }
}
