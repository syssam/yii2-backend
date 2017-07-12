<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "industry_type".
 *
 * @property integer $industry_type_id
 * @property integer $status
 * @property integer $sort_order
 */
class IndustryType extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'industry_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sort_order'], 'integer'],
            [['sort_order'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'industry_type_id' => Yii::t('app', 'Industry Type ID'),
            'status' => Yii::t('app', 'Status'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }

    public function getIndustryTypeDescription()
    {
        return $this->hasOne(IndustryTypeDescription::className(), ['industry_type_id' => 'industry_type_id'])
        ->andOnCondition(['language_id' => Yii::$app->languageManager->getDefaultId()]);
    }
}
