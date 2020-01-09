<?php

use yii\db\Migration;

/**
 * Class m200109_072926_add_tripadvisor_to_restaurant
 */
class m200109_072926_add_tripadvisor_to_restaurant extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization', 'tripadvisor_url', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organization', 'tripadvisor_url');
    }

}
