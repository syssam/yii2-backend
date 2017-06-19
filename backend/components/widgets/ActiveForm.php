<?php

namespace backend\components\widgets;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $options = [
      'class' => 'form-horizontal',
      'enctype' => 'multipart/form-data',
    ];

    public $fieldClass = 'backend\components\widgets\ActiveField';
}
