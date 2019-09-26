<?php

use yii\db\Migration;

/**
 * Class m190926_065658_add_description_to_organization
 */
class m190926_065658_add_description_to_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organization', 'description');
    }
}
