<?php

use yii\db\Migration;

/**
 * Handles the creation of table `proposal`.
 */
class m180723_082855_create_proposal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('proposal', [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer()->notNull(),
            'City' => $this->string()->notNull(),
            'date' => $this->date()->notNull(),
            'time' => $this->time()->notNull(),
            'guests_count' => $this->integer()->notNull(),
            'amount' => $this->double(2)->notNull(),
            'type' => $this->integer()->notNull(),
            'event_type' => $this->integer()->notNull(),
            'metro' => $this->integer()->notNull(),
            'cuisine' => $this->integer()->notNull(),
            'dance' => $this->boolean()->defaultValue(false),
            'private' => $this->boolean()->defaultValue(false),
            'own_alcohol' => $this->boolean()->defaultValue(false),
            'parking' => $this->boolean()->defaultValue(false),
            'comment' => $this->text()
        ]);

        $this->addForeignKey('proposal_user_fk', 'proposal', 'owner_id', 'mobile_user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('proposal');
    }
}
