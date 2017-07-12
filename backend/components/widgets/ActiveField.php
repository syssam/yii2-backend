<?php

namespace backend\components\widgets;

use backend\assets\SummernoteAsset;
use common\components\helpers\ImageHelper;
use yii\helpers\Html;
use Yii;
use yii\helpers\Url;

class ActiveField extends \yii\widgets\ActiveField
{
    public $options = ['class' => 'form-group'];

    public $template = "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>";

    public $labelOptions = ['class' => 'col-sm-2 control-label'];

    private $_skipLabelFor = false;

    public function imageInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $image = '<a href="" id="thumb-'.Html::getInputId($this->model, $this->attribute).'" data-toggle="image" class="img-thumbnail">
                    <img src="'.ImageHelper::resize(Html::getAttributeValue($this->model, $this->attribute), 100, 100).'">
                  </a>';
        $this->parts['{input}'] = $image.Html::activeHiddenInput($this->model, $this->attribute, $options);

        return $this;
    }

    public function editorInput($options = [])
    {
        $this->inputOptions = ['class' => 'form-control summernote'];
        $options = array_merge($this->inputOptions, $options);
        $view = $this->form->getView();
        SummernoteAsset::register($view);
        $this->textarea($options);

        return $this;
    }

    public function langInput($options = [])
    {
        $this->options = ['class' => 'form-group'];
        $this->inputOptions = ['class' => 'form-control'];
        $this->enableClientValidation = false;

        $languages = Yii::$app->languageManager->getLanguages();
        $input = '';
        $index = isset($options['index']) ? "[{$options['index']}]" : '';
        unset($options['index']);
        $models = $this->model;
        foreach ($models as $language_id => $model) {
            $input_addon = '<span class="input-group-addon"><img src="'.Url::to('@web/image/').$languages[$language_id]->image.'" title="'.$languages[$language_id]->name.'"></span>';
            $filed = new ActiveField([
                'form' => $this->form,
                'model' => $model,
                'attribute' => "{$index}[{$language_id}]".$this->attribute,
                'options' => ['class' => 'input-control'],
                'inputOptions' => ['class' => 'form-control'],
                'template' => "<div class=\"input-group\">{$input_addon}{input}\n{hint}</div>\n{error}"
            ]);
            $input .= $filed->textInput();
            $this->model = $model;
        }

        $this->parts['{input}'] = $input;
        $this->parts['{error}'] = '';

        return $this;
    }

    public function checkboxList($items, $options = [])
    {
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->_skipLabelFor = true;
        $this->parts['{input}'] = '<div class="well well-sm" style="height: 150px; overflow: auto;">'.Html::activeCheckboxList($this->model, $this->attribute, $items, $options).'</div>';

        return $this;
    }
}
