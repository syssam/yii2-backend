<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ManufacturerSearch represents the model behind the search form about `common\models\Manufacturer`.
 */
class ManufacturerSearch extends Manufacturer
{
    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manufacturer_id', 'sort_order'], 'integer'],
            [['image'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        //$query = Manufacturer::find()->select('*')->leftJoin('manufacturer_description', '`manufacturer`.`manufacturer_id` = `manufacturer_description`.`manufacturer_id` and `language_id` = 1');
        //$query = Manufacturer::find()->joinWith('manufacturerDescription');
        $query = Manufacturer::find()->joinWith('manufacturerDescription');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['name'] = [
             'asc' => ['manufacturer_description.name' => SORT_ASC],
             'desc' => ['manufacturer_description.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'manufacturer_id' => $this->manufacturer_id,
            'sort_order' => $this->sort_order,
        ]);

        //$query->andFilterWhere(['like', 'image', $this->image]);
        $query->andFilterWhere(['like', 'manufacturer_description.name', $this->name.'%', false]);

        return $dataProvider;
    }
}
