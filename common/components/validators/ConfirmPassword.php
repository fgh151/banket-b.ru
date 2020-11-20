<?php
/**
 * Валидаторы
 * @author : Fedor B Gorsky
 */

namespace app\common\components\validators;

use yii\validators\Validator;

/**
 * Class ConfirmPassword Валидатор для проверки совпадения пароля и подтверждения
 * @package app\common\components\validators
 * @see app\cabinet\models\SignupForm::rules()
 */
class ConfirmPassword extends Validator
{
    /** @var string Аргумент для сравнения */
    public $second_argument;

    /**
     * Валидатор
     *
     * @param \yii\base\Model $model Модель для валидации
     * @param string          $attribute Аттрибут для валидации.
     */
    public function validateAttribute($model, $attribute)
    {
        $second_argument = $this->second_argument;
        if ($model->$attribute !== $model->$second_argument) {
            $model->addError($attribute, 'Пароли не совпадают');
        }
    }
}