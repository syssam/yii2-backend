<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%park_description}}".
 *
 * @property integer $park_id
 * @property string $name
 * @property string $address
 * @property string $description
 * @property string $video
 * @property string $owner
 * @property integer $language_id
 */
class ParkDescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%park_description}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'video', 'owner'], 'required'],
            [['description'], 'string'],
            [['name', 'address', 'video', 'owner'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'park_id' => Yii::t('app/attribute', 'Park ID'),
            'name' => Yii::t('app/attribute', 'Name'),
            'address' => Yii::t('app/attribute', 'Address'),
            'description' => Yii::t('app/attribute', 'Description'),
            'video' => Yii::t('app/attribute', 'Video'),
            'owner' => Yii::t('app/attribute', 'Owner'),
            'language_id' => Yii::t('app/attribute', 'Language ID'),
        ];
    }
}
