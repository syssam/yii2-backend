<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "industry_type_description".
 *
 * @property integer $industry_type_id
 * @property string $name
 * @property integer $language_id
 */
class IndustryTypeDescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'industry_type_description';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'industry_type_id' => Yii::t('app', 'Industry Type ID'),
            'name' => Yii::t('app', 'Name'),
            'language_id' => Yii::t('app', 'Language ID'),
        ];
    }
}
