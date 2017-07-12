<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%park}}".
 *
 * @property int $park_id
 * @property int $location_id
 * @property int $park_type_id
 * @property int $manufacturer_id
 * @property string $telephone
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 */
class Park extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%park}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location_id', 'park_type_id', 'manufacturer_id', 'sort_order'], 'integer'],
            [['telephone', 'created_at', 'updated_at', 'location_id', 'park_type_id', 'manufacturer_id'], 'required'],
            [['telephone'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'park_id' => Yii::t('app', 'Park ID'),
            'location_id' => Yii::t('app', 'Location'),
            'park_type_id' => Yii::t('app', 'Park Type'),
            'manufacturer_id' => Yii::t('app', 'Manufacturer'),
            'telephone' => Yii::t('app', 'Telephone'),
            'status' => Yii::t('app', 'Status'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getParkDescription()
    {
        return $this->hasOne(ParkDescription::className(), ['park_id' => 'park_id'])
      ->andOnCondition(['language_id' => Yii::$app->languageManager->getDefaultId()]);
    }

    public function getParkAttribute()
    {
        return $this->hasMany(ParkAttribute::className(), ['park_id' => 'park_id']);
    }
}
