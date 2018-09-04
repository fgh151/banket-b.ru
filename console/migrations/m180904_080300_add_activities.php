<?php

use yii\db\Migration;

use app\common\models\Activity;

/**
 * Class m180904_080300_add_activities
 */
class m180904_080300_add_activities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $activity = new Activity();
        $activity->title = 'Ресторан';
        $activity->save();
        $activity = new Activity();
        $activity->title = 'Флористика';
        $activity->save();
        $activity = new Activity();
        $activity->title = 'Оформителение залов';
        $activity->save();
        $activity = new Activity();
        $activity->title = 'Фото / Видео';
        $activity->save();
        $activity = new Activity();
        $activity->title = 'Стилисты';
        $activity->save();
        $activity = new Activity();
        $activity->title = 'Кондитерская';
        $activity->save();
        $activity = new Activity();
        $activity->title = 'Развлекательное агенство';
        $activity->save();
        $activity = new Activity();
        $activity->title = 'Транспортная компания';
        $activity->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180904_080300_add_activities cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180904_080300_add_activities cannot be reverted.\n";

        return false;
    }
    */
}
