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
class Tag extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }

    public function getTagDescription()
    {
        return $this->hasOne(TagDescription::className(), ['tag_id' => 'tag_id'])
      ->andOnCondition(['language_id' => Yii::$app->languageManager->getDefaultId()]);
    }
}
