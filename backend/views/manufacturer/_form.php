<?php
use backend\components\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Manufacturer */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
      'id' => $model->formName(),
    ]); ?>
    <?= $form->field($model, 'image')->ImageInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>
    <div>
      <ul class="nav nav-tabs" id="language">
        <?php
        foreach ($languages as $index => $language) {
            ?>
        <li<?= $index == 0 ? ' class="active"' : ''?>><a href="#language<?=$language->language_id?>" data-toggle="tab" aria-expanded="true"><img src="<?=Url::to('@web/image/').$language->image?>" title="<?=$language->name?>"> <?=$language->name?></a></li>
        <?php

        }
        ?>
      </ul>
      <div class="tab-content">
        <?php
        $i = 0;
        foreach ($manufacturer_description as $language_id => $manufacturer) {
            ?>
        <div class="tab-pane<?= $i == 0 ? ' active' : ''?>" id="language<?=$language_id?>">
          <?= $form->field($manufacturer, "[{$language_id}]name")->textInput() ?>
          <?= $form->field($manufacturer, "[{$language_id}]description")->EditorInput() ?>
        </div>
        <?php
          ++$i;
        }?>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
