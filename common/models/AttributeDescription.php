<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%attribute_description}}".
 *
 * @property int $attribute_id
 * @property string $name
 * @property int $language_id
 */
class AttributeDescription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%attribute_description}}';
    }

    /**
     * {@inheritdoc}ww
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
}
