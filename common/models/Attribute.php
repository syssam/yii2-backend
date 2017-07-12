<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%attribute}}".
 *
 * @property int $attribute_id
 * @property int $sort_order
 */
class Attribute extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%attribute}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['sort_order', 'type'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }

    public function getAttributeDescription()
    {
        return $this->hasOne(AttributeDescription::className(), ['attribute_id' => 'attribute_id'])
      ->andOnCondition(['language_id' => Yii::$app->languageManager->getDefaultId()]);
    }
}
