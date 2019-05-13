<?php

namespace app\common\models;

use app\common\components\Constants;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProposalSearch represents the model behind the search form of `app\common\models\Proposal`.
 */
class ProposalSearch extends Proposal
{
    public $rejected;

    public $order;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'owner_id', 'guests_count', 'event_type', 'metro'], 'integer'],
            [['City', 'date', 'time', 'comment', 'status', 'rejected'], 'safe'],
            [['amount'], 'number'],
            [['dance', 'private', 'own_alcohol', 'parking'], 'boolean'],
            ['order', 'in', 'range' => ['date']]
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $direct = false, $admin = false)
    {
        $query = Proposal::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]]
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
            'date' => $this->date,
            'time' => $this->time,
            'event_type' => $this->event_type,
            'metro' => $this->metro,
            'dance' => $this->dance,
            'private' => $this->private,
            'own_alcohol' => $this->own_alcohol,
            'parking' => $this->parking,
//            'status' => $this->status
        ]);

        $query->andFilterWhere(['>', 'guests_count', $this->guests_count]);

        if (!$admin) {
            if ($direct == false) {
                $query->andFilterWhere(['organizations' => '"[]"']);
            } else {
                $query->andFilterWhere(['@>', 'organizations', '[' . $direct . ']']);
            }
        }

        if ($this->status !== null) {
            if ($this->status == Constants::PROPOSAL_STATUS_CREATED) {
                $query->andFilterWhere(['status' => Constants::PROPOSAL_STATUS_CREATED]);
            } else {
                $query->andFilterWhere(['in', 'status', [Constants::PROPOSAL_STATUS_CLOSED, Constants::PROPOSAL_STATUS_REJECT]]);
            }
        }

        $query->andFilterWhere(['>', 'amount', $this->amount]);

        $query->andFilterWhere(['ilike', 'City', $this->City])
            ->andFilterWhere(['ilike', 'comment', $this->comment]);

//        $query->orderBy('id DESC');


        if ($this->rejected) {
            $query->andWhere([
                'not in',
                'id', $this->rejected]);
        }


        return $dataProvider;
    }
}
