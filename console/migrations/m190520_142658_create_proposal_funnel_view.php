<?php

use yii\db\Migration;

/**
 * Class m190520_142658_create_proposal_funnel_view
 */
class m190520_142658_create_proposal_funnel_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(
            'CREATE VIEW proposal_funnel AS SELECT
       p.id, p.owner_id,
  c.cost,
       f.uid
FROM proposal p
LEFT JOIN cost c ON c.proposal_id = p.id
LEFT JOIN funnel f ON f.extra->>\'id\' = cast ( p.id as text )'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP VIEW proposal_funnel');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190520_142658_create_proposal_funnel_view cannot be reverted.\n";

        return false;
    }
    */
}
