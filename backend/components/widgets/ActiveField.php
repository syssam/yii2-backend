<?php

namespace backend\components\widgets;

use backend\assets\SummernoteAsset;
use common\components\helpers\ImageHelper;
use yii\helpers\Html;

class ActiveField extends \yii\widgets\ActiveField
{
    public $options = ['class' => 'form-group'];

    public $template = "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>";

    public $labelOptions = ['class' => 'col-sm-2 control-label'];

    public function ImageInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $attribute = $this->attribute;
        $this->adjustLabelFor($options);
        $image = '<a href="" id="thumb-'.$attribute.'" data-toggle="image" class="img-thumbnail">
                    <img src="'.ImageHelper::resize($this->model->$attribute, 100, 100).'">
                  </a>';
        $this->parts['{input}'] = $image.Html::activeHiddenInput($this->model, $this->attribute, $options);

        return $this;
    }

    public function EditorInput($options = [])
    {
        $this->inputOptions = ['class' => 'form-control summernote'];
        $options = array_merge($this->inputOptions, $options);
        $view = $this->form->getView();
        SummernoteAsset::register($view);
        $this->textarea($options);

        return $this;
    }
}
