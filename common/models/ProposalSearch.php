<?php

namespace app\common\models;

use app\common\components\Constants;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * ProposalSearch represents the model behind the search form of `app\common\models\Proposal`.
 */
class ProposalSearch extends Proposal
{
    public $rejected;

    public $order;

    public $with = ['owner'];

    public $amount_to;

    public $guests_count_to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'owner_id', 'guests_count', 'guests_count_to', 'event_type', 'metro'], 'integer'],
            [['City', 'date', 'time', 'comment', 'status', 'rejected'], 'safe'],
            [['amount', 'amount_to'], 'number'],

            [['dance', 'private', 'own_alcohol', 'parking'], 'boolean'],
            ['order', 'in', 'range' => ['date']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'guests_count' => 'Количество гостей',
            'amount' => 'Стоимость'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param ActiveQuery $query
     * @param $field
     * @return ActiveQuery
     */
    private function addBoolCondition(ActiveQuery $query, $field)
    {
        if ($this->$field !== null) {
            $query->andFilterWhere([$field => $this->$field]);
        }
        return $query;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $direct = false, $admin = false)
    {
        $query = Proposal::find()->with($this->with);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        if ($this->order) {
            $dataProvider->sort = ['defaultOrder' => [$this->order => SORT_DESC]];
        }


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');


            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'time' => $this->time,
            'event_type' => $this->event_type,
        ]);

        $query->andFilterWhere([
            'or',
            ['metro' => $this->metro],
            ['metro' => null]
        ]);

        $query = $this->addBoolCondition($query, 'dance');
        $query = $this->addBoolCondition($query, 'private');
        $query = $this->addBoolCondition($query, 'own_alcohol');
        $query = $this->addBoolCondition($query, 'parking');

        if ($this->date) {
            $query->andWhere(['>=', 'date', $this->date]);
        }

        if ($this->guests_count !== null) {
            $query->andFilterWhere(['>', 'guests_count', $this->guests_count]);
        }
        if ($this->guests_count_to !== null) {
            $query->andFilterWhere(['<', 'guests_count', $this->guests_count_to]);
        }
//        if (!$admin) {
//            if ($direct == false) {
//                $query->andFilterWhere(['organizations' => '"[]"']);
//            } else {
//                $query->andFilterWhere(['@>', 'organizations', '[' . $direct . ']']);
//            }
//        }

        if ($this->status !== null) {
            if ($this->status == Constants::PROPOSAL_STATUS_CREATED) {
                $query->andFilterWhere(['status' => Constants::PROPOSAL_STATUS_CREATED]);
            } else {
                $query->andFilterWhere(['in', 'status', [Constants::PROPOSAL_STATUS_CLOSED, Constants::PROPOSAL_STATUS_REJECT]]);
            }
        }

        if ($this->amount) {
            $query->andFilterWhere(['>', 'amount', $this->amount]);
        }
        if ($this->amount_to) {
            $query->andFilterWhere(['<', 'amount', $this->amount_to]);
        }

        $query->andFilterWhere(['ilike', 'City', $this->City])
            ->andFilterWhere(['ilike', 'comment', $this->comment]);

        $query->orderBy('date ASC');


        //TODO: переделать. Сделать join и фильтровать по нему
        if ($this->rejected) {
            $query->andWhere([
                'not in',
                'id', $this->rejected]);
        }

//        var_dump($query->createCommand()->getRawSql()); die;


        return $dataProvider;
    }
}
