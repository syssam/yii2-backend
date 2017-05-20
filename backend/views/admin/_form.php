<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
        'options' => [
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data',
        ],
      ]); ?>
    <?= $form->field($model, 'username', [
      'template' => '{label}<div class="col-sm-10">{input}{error}</div>',
      'labelOptions' => [
          'class' => 'col-sm-2 control-label',
      ],
    ])->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email', [
      'template' => '{label}<div class="col-sm-10">{input}{error}</div>',
      'labelOptions' => [
          'class' => 'col-sm-2 control-label',
      ],
    ])->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password', [
      'template' => '{label}<div class="col-sm-10">{input}{error}</div>',
      'labelOptions' => [
          'class' => 'col-sm-2 control-label',
      ],
      'options' => [
          'class' => $model->isNewRecord ? 'form-group required' : 'form-group',
      ],
    ])->passwordInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'comfirm', [
      'template' => '{label}<div class="col-sm-10">{input}{error}</div>',
      'labelOptions' => [
          'class' => 'col-sm-2 control-label',
      ],
      'options' => [
          'class' => $model->isNewRecord ? 'form-group required' : 'form-group',
      ],
    ])->passwordInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'status', [
      'template' => '{label}<div class="col-sm-10">{input}{error}</div>',
      'labelOptions' => [
          'class' => 'col-sm-2 control-label',
      ],
    ])->dropDownList([
      $model::STATUS_DELETED => 'Disabled',
      $model::STATUS_ACTIVE => 'Enabled',
    ]) ?>
    <?php ActiveForm::end(); ?>
