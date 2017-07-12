<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zone_description".
 *
 * @property integer $zone_id
 * @property string $name
 * @property integer $language_id
 */
class ZoneDescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zone_description';
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
            'zone_id' => Yii::t('app', 'Zone ID'),
            'name' => Yii::t('app', 'Name'),
            'language_id' => Yii::t('app', 'Language ID'),
        ];
    }
}
