<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%park_attribute}}".
 *
 * @property integer $park_id
 * @property integer $attribute_id
 * @property string $text
 * @property integer $language_id
 */
class ParkAttribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%park_attribute}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id'], 'required'],
            [['park_id', 'attribute_id', 'language_id'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text' => Yii::t('app', 'Text'),
        ];
    }
}
