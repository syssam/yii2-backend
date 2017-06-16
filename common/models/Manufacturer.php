<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%manufacturer}}".
 *
 * @property int $manufacturer_id
 * @property string $image
 * @property int $sort_order
 */
class Manufacturer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%manufacturer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'sort_order'], 'required'],
            [['sort_order'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'manufacturer_id' => Yii::t('app', 'Manufacturer ID'),
            'name' => Yii::t('app', 'Manufacturer Name'),
            'image' => Yii::t('app', 'Image'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }

    public function getManufacturerDescription()
    {
        return $this->hasOne(ManufacturerDescription::className(), ['manufacturer_id' => 'manufacturer_id'])->andWhere(['language_id' => Yii::$app->languageManager->getDefaultId()]);
    }
}
