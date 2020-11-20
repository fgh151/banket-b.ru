<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-06-05
 * Time: 14:46
 */

namespace app\common\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Class Feedback
 * @package app\common\models
 *
 * @property integer $user_id
 * @property integer $id
 * @property string $created_at
 * @property string $content
 */
class Feedback extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    public function fields()
    {
        return [
            'id', 'created_at', 'user_id', 'content'
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Сообщение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery| MobileUser
     */
    public function getUser()
    {
        return $this->hasOne(MobileUser::class, ['id' => 'user_id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            Yii::$app->mailer->compose()
                ->setFrom(getenv('MAIL_FROM'))
                ->setTo('banketbatl@mail.ru')
                ->setSubject('Новая запись в обратной связи')
                ->setHtmlBody(' <a href="https://admin.banket-b.ru/feedback/index">Посмотреть</a>')
                ->send();
        }
    }
}
