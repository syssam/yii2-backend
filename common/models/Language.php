<?php

namespace common\models;

class Language extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%language}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'string', 'max' => 5],
            [['name', 'image'], 'string', 'max' => 255],
            ['sort_order', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public static function findByLanguageCode($code)
    {
        return static::findOne(['code' => $code, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findLanguages()
    {
        return static::find(['status' => self::STATUS_ACTIVE])->indexBy('language_id')->orderBy('sort_order')->all();
    }
}
