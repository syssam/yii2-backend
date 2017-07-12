<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "park_type_description".
 *
 * @property integer $park_type_id
 * @property string $name
 * @property integer $language_id
 */
class ParkTypeDescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'park_type_description';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
