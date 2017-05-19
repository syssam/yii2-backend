<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Admin;

/**
 * AdminSearch represents the model behind the search form about `common\models\Admin`.
 */
class AdminSearch extends Admin
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'safe'],
            [['created_at', 'updated_at'], 'date'],
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
        $query = Admin::find();

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
            'status' => $this->status,
        ]);

        if ($this->created_at != null) {
            $created_at = date_create($this->created_at);
            $created_at = date_time_set($created_at, 00, 00, 00);
            $created_at = \Yii::$app->formatter->asTimestamp($created_at);
            $query->andFilterWhere(['between', 'created_at', $created_at, strtotime('+24 hours', $created_at)]);
        }

        if ($this->updated_at != null) {
            $updated_at = date_create($this->updated_at);
            $updated_at = date_time_set($updated_at, 00, 00, 00);
            $updated_at = \Yii::$app->formatter->asTimestamp($updated_at);
            $query->andFilterWhere(['between', 'updated_at', $updated_at, strtotime('+24 hours', $updated_at)]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
