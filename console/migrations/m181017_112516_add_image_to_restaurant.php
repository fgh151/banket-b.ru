<?php

use yii\db\Migration;

/**
 * Class m181017_112516_add_image_to_restaurant
 */
class m181017_112516_add_image_to_restaurant extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization_image', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'upload_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('organization_image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_112516_add_image_to_restaurant cannot be reverted.\n";

        return false;
    }
    */
}
