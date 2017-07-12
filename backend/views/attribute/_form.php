<?php

use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Attribute */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin([
      'id' => $model->formName(),
    ]); ?>


    <?= $form->field($attribute_description, 'name')->langInput() ?>
    <?= $form->field($attribute_description, 'value')->langInput() ?>
    <?= $form->field($model, 'type')->dropDownList([
      '1' => '1'
    ]) ?>
    <?= $form->field($model, 'status')->dropDownList([
      $model::STATUS_DELETED => 'Disabled',
      $model::STATUS_ACTIVE => 'Enabled',
    ]) ?>
    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?php ActiveForm::end(); ?>
