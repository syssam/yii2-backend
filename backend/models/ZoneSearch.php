<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Zone;

/**
 * ZoneSearch represents the model behind the search form about `common\models\Zone`.
 */
class ZoneSearch extends Zone
{
    public $name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sort_order'], 'integer'],
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
        $query = Zone::find()->joinWith('zoneDescription');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['name'] = [
             'asc' => ['zone_description.name' => SORT_ASC],
             'desc' => ['zone_description.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'zone_id' => $this->zone_id,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
        ]);

        $query->andFilterWhere(['like', 'zone_description.name', $this->name.'%', false]);

        return $dataProvider;
    }
}