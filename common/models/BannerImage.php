<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%banner_image}}".
 *
 * @property int $banner_image_id
 * @property string $title
 * @property string $link
 * @property string $image
 * @property int $sort_order
 */
class BannerImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%banner_image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort_order'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['link', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('banner', 'Title'),
            'link' => Yii::t('banner', 'Link'),
            'image' => Yii::t('banner', 'Image'),
            'sort_order' => Yii::t('banner', 'Sort Order'),
        ];
    }
}
