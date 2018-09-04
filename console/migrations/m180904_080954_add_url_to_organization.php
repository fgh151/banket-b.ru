<?php

use yii\db\Migration;

/**
 * Class m180904_080954_add_url_to_organization
 */
class m180904_080954_add_url_to_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'url', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180904_080954_add_url_to_organization cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180904_080954_add_url_to_organization cannot be reverted.\n";

        return false;
    }
    */
}
