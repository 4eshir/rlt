<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * SearchProduct represents the model behind the search form of `app\models\Product`.
 */
class SearchProduct extends Product
{
    public $nameView;
    public $currencyString;
    public $statusString;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'currency_id', 'price', 'user_creator_id', 'count', 'status_id'], 'integer'],
            [['name', 'description', 'photo'], 'safe'],
            [['currencyString', 'statusString', 'nameView'], 'string'],
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
        $query = Product::find()->orderBy(['status_id' => SORT_ASC, 'id' => SORT_ASC]);

        $query->joinWith(['currency currency']);
        $query->joinWith(['status status']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['statusString'] = [
            'asc' => ['status.name' => SORT_ASC],
            'desc' => ['status.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['currencyString'] = [
            'asc' => ['currency.name' => SORT_ASC],
            'desc' => ['currency.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['nameView'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'currency_id' => $this->currency_id,
            'price' => $this->price,
            'user_creator_id' => $this->user_creator_id,
            'count' => $this->count,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'name', $this->nameView])
            ->andFilterWhere(['like', 'status.name', $this->statusString])
            ->andFilterWhere(['like', 'currency.name', $this->currencyString]);

        return $dataProvider;
    }
}
