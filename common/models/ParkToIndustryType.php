<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%park_to_industry_type}}".
 *
 * @property integer $park_id
 * @property integer $industry_type_id
 */
class ParkToIndustryType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%park_to_industry_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['industry_type_id'], 'required'],
            [['industry_type_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'industry_type_id' => Yii::t('app', 'Industry Type'),
        ];
    }
}
