<?php

use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ParkType */
/* @var $form backend\components\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin([
      'id' => $model->formName(),
    ]); ?>

    <?= $form->field($park_type_description, 'name')->langInput() ?>

    <?= $form->field($model, 'status')->dropDownList([
      $model::STATUS_DELETED => 'Disabled',
      $model::STATUS_ACTIVE => 'Enabled',
    ]) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>


    <?php ActiveForm::end(); ?>
