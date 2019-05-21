<?php

namespace app\common\models;

use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * Вьюшка read only
 *
 * @property int $id
 * @property int $owner_id
 * @property int $cost
 * @property string $uid
 */
class ProposalFunnel extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proposal_funnel';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'cost' => 'Cost',
            'uid' => 'Uid',
        ];
    }


    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool|void
     * @throws Exception
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        throw new Exception('Нельза сохранить запись в View');
    }

    /**
     * @return false|int|void
     * @throws Exception
     */
    public function delete()
    {
        throw new Exception('Нельза удалить запись из View');
    }

}
