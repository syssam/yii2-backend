<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tag_description}}".
 *
 * @property integer $tag_id
 * @property string $name
 * @property integer $language_id
 */
class TagDescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag_description}}';
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
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
