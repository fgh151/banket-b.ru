<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-31
 * Time: 10:58
 */

namespace app\admin\models;


use app\common\models\ProposalSearch;
use yii\base\Model;

class ProposalSearchForm extends Model
{

    public $danceTrue;
    public $danceFalse;

    public $privateTrue;
    public $privateFalse;

    public $own_alcoholTrue;
    public $own_alcoholFalse;

    public $parkingTrue;
    public $parkingFalse;

    public $guests_count;
    public $amount;
    public $amount_to;
    public $guests_count_to;


    public function rules()
    {
        return [
            [['danceFalse', 'danceTrue', 'privateFalse', 'privateTrue', 'own_alcoholFalse', 'own_alcoholTrue', 'parkingTrue', 'parkingFalse'], 'boolean'],
            [['danceFalse', 'danceTrue', 'privateFalse', 'privateTrue', 'own_alcoholFalse', 'own_alcoholTrue', 'parkingTrue', 'parkingFalse'], 'default', 'value' => true],
            [['guests_count', 'guests_count_to', 'amount', 'amount_to'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'danceFalse' => 'Заявки с танцполом',
            'danceTrue' => 'Заявки без танцпола',
            'privateFalse' => 'Заявки с отдельным залом',
            'privateTrue' => 'Заявки без отдельного зала',
            'own_alcoholFalse' => 'Со свойи алкоголем',
            'own_alcoholTrue' => 'Без своего алкоголя',
            'parkingTrue' => 'С парковкой',
            'parkingFalse' => 'Без парковки',
            'guest_count' => 'Количество гостей от',
            'amount', 'Стоимость от'
        ];
    }

    public function createForm(ProposalSearch $model)
    {
        $this->guests_count = $model->guests_count;
        $this->guests_count_to = $model->guests_count_to;
        $this->amount = $model->amount;
        $this->amount_to = $model->amount_to;

        $this->createBooleanFormField($model, 'dance');
        $this->createBooleanFormField($model, 'private');
        $this->createBooleanFormField($model, '$own_alcohol');
        $this->createBooleanFormField($model, '$parking');
    }


    private function createBooleanFormField(ProposalSearch $model, $field)
    {
        $true = $field . 'True';
        $false = $field . 'False';

        $this->$true = $model->dance === true;
        $this->$false = $model->dance === false;
        if ($model->$field === null) {
            $this->$false = $this->$true = true;
        }
    }


    public function createFilter()
    {
        $filter = new ProposalSearch();
        $filter = $this->addBooleanFilter($filter, 'dance');
        $filter = $this->addBooleanFilter($filter, 'private');
        $filter = $this->addBooleanFilter($filter, 'own_alcohol');
        $filter = $this->addBooleanFilter($filter, 'parking');

        $filter = $this->addIntFilter($filter, 'guests_count');
        $filter = $this->addIntFilter($filter, 'guests_count_to');
        $filter = $this->addIntFilter($filter, 'amount');
        $filter = $this->addIntFilter($filter, 'amount_to');

        return $filter;
    }

    private function addBooleanFilter(ProposalSearch $model, $field)
    {
        $true = $field . 'True';
        $false = $field . 'False';

        if ($true && $false) {
            $model->dance = null;
        } elseif ($true) {
            $model->dance = true;
        } else {
            $model->dance = false;
        }
        return $model;
    }

    private function addIntFilter(ProposalSearch $model, $field)
    {
        if ($this->$field !== '') {
            $model->$field = $this->$field;
        }
        return $model;
    }

}