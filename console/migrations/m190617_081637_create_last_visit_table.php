<?php

use yii\db\Migration;

/**
 * Handles the creation of table `last_visit`.
 */
class m190617_081637_create_last_visit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'last_visit', $this->dateTime());
        $this->addColumn('organization', 'send_notify', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organization', 'last_visit');
        $this->dropColumn('organization', 'send_notify');
    }
}
