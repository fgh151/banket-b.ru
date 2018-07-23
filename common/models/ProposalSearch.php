<?php

namespace app\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\models\Proposal;

/**
 * ProposalSearch represents the model behind the search form of `app\common\models\Proposal`.
 */
class ProposalSearch extends Proposal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'owner_id', 'guests_count', 'type', 'event_type', 'metro', 'cuisine'], 'integer'],
            [['City', 'date', 'time', 'comment'], 'safe'],
            [['amount'], 'number'],
            [['dance', 'private', 'own_alcohol', 'parking'], 'boolean'],
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
    public function search($params)
    {
        $query = Proposal::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
            'guests_count' => $this->guests_count,
            'amount' => $this->amount,
            'type' => $this->type,
            'event_type' => $this->event_type,
            'metro' => $this->metro,
            'cuisine' => $this->cuisine,
            'dance' => $this->dance,
            'private' => $this->private,
            'own_alcohol' => $this->own_alcohol,
            'parking' => $this->parking,
        ]);

        $query->andFilterWhere(['ilike', 'City', $this->City])
            ->andFilterWhere(['ilike', 'comment', $this->comment]);

        return $dataProvider;
    }
}
