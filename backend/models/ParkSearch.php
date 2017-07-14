<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Park;

/**
 * ParkSearch represents the model behind the search form about `common\models\Park`.
 */
class ParkSearch extends Park
{
    public $name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['park_id', 'location_id', 'park_type_id', 'manufacturer_id', 'status', 'sort_order', 'created_at', 'updated_at'], 'integer'],
            [['telephone'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Park::find()->joinWith('parkDescription');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['name'] = [
             'asc' => ['park_description.name' => SORT_ASC],
             'desc' => ['park_description.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'park_id' => $this->park_id,
            'location_id' => $this->location_id,
            'park_type_id' => $this->park_type_id,
            'manufacturer_id' => $this->manufacturer_id,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'park_description.name', $this->name.'%', false]);

        return $dataProvider;
    }
}
