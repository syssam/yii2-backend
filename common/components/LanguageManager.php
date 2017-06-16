<?php

namespace common\components;

class LanguageManager extends \yii\base\Object
{
    public $language_id;
    public $languages;

    public function init()
    {
        parent::init();
    }

    public function getLanguages()
    {
        if (!isset($this->languages)) {
            $this->languages = \common\models\Language::findLanguages();
        }

        return $this->languages;
    }

    public function getDefaultId()
    {
        if (!isset($this->language_id)) {
            $model = \common\models\Language::findByLanguageCode(\Yii::$app->language);
            if (!$model) {
                throw new InvalidConfigException('Unable to get language_id from '.\Yii::$app->language);
            }
            $this->language_id = $model->language_id;
        }

        return $this->language_id;
    }
}
