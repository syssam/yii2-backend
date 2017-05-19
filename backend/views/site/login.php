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
          <div class="form-group">
            <label for="input-username">username</label>
            <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
              <input type="text" name="username" value="" placeholder="username" id="input-username" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label for="input-password">Password</label>
            <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control" />
            </div>
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> Login</button>
          </div>
          <input type="hidden" name="redirect" value="redirect" />
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>
