<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<br>
<br>
<div class="row">
  <div class="col-sm-offset-4 col-sm-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1 class="panel-title"><i class="fa fa-lock"></i> Login</h1>
      </div>
      <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
          <?= $form->field($model, 'username', ['template' => '{label}<div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>{input}</div>{error}'
          ])->textInput(['autofocus' => true]) ?>
          <?= $form->field($model, 'password', ['template' => '{label}<div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>{input}</div>{error}'
          ])->passwordInput() ?>
          <div class="text-right">
            <?= Html::submitButton('<i class="fa fa-key"></i> Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
          </div>
          <input type="hidden" name="redirect" value="redirect" />
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>
