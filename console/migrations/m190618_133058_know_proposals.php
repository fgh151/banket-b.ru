<?php

use yii\db\Migration;

/**
 * Class m190618_133058_know_proposals
 */
class m190618_133058_know_proposals extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $proposals = \app\api\models\Proposal::find()->all();
        $orgs = \app\api\models\Organization::find()->all();

        foreach ($proposals as $proposal) {
            foreach ($orgs as $org) {
                $knowledge = new \app\common\models\KnownProposal();
                $knowledge->proposal_id = $proposal->id;
                $knowledge->organization_id = $org->id;
                $knowledge->save();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190618_133058_know_proposals cannot be reverted.\n";

        return false;
    }
    */
}
