<?php

use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\IndustryType */
/* @var $form backend\components\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin([
      'id' => $model->formName(),
    ]); ?>

    <?= $form->field($industry_type_description, 'name')->langInput() ?>

    <?= $form->field($model, 'status')->dropDownList([
      $model::STATUS_DELETED => 'Disabled',
      $model::STATUS_ACTIVE => 'Enabled',
    ]) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>


    <?php ActiveForm::end(); ?>
