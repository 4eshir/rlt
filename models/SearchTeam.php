<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Team;

/**
 * SearchTeam represents the model behind the search form of `app\models\Team`.
 */
class SearchTeam extends Team
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_creator_id', 'currency_id', 'max_count', 'summary_cost', 'status_id'], 'integer'],
            [['name', 'date_start', 'date_finish'], 'safe'],
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
        $query = Team::find();

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
            'user_creator_id' => $this->user_creator_id,
            'currency_id' => $this->currency_id,
            'max_count' => $this->max_count,
            'summary_cost' => $this->summary_cost,
            'status_id' => $this->status_id,
            'date_start' => $this->date_start,
            'date_finish' => $this->date_finish,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
