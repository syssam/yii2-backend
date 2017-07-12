<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Attribute;

/**
 * AttributeSearch represents the model behind the search form about `common\models\Attribute`.
 */
class AttributeSearch extends Attribute
{
    public $name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id', 'status', 'sort_order'], 'integer'],
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
        $query = Attribute::find()->joinWith('attributeDescription');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['name'] = [
             'asc' => ['attribute_description.name' => SORT_ASC],
             'desc' => ['attribute_description.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'attribute_id' => $this->attribute_id,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'attribute_description.name', $this->name.'%', false]);

        return $dataProvider;
    }
}
