<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\components\helpers\ImageHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Manufacturer */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
      'id' => $model->formName(),
      'options' => [
          'class' => 'form-horizontal',
          'enctype' => 'multipart/form-data',
      ],
    ]); ?>
    <?= $form->field($model, 'image', [
      'template' => '{label}<div class="col-sm-10">
          <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
            <img src="'.ImageHelper::resize($model->image, 100, 100).'">
          </a>
          {input}{error}</div>',
      'labelOptions' => [
          'class' => 'col-sm-2 control-label',
      ],
    ])->hiddenInput() ?>

    <?= $form->field($model, 'sort_order', [
      'template' => '{label}<div class="col-sm-10">{input}{error}</div>',
      'labelOptions' => [
          'class' => 'col-sm-2 control-label',
      ],
    ])->textInput() ?>
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
          <?= $form->field($manufacturer, "[{$language_id}]name", [
            'template' => '{label}<div class="col-sm-10">{input}{error}</div>',
            'labelOptions' => [
                'class' => 'col-sm-2 control-label',
            ],
          ])->textInput() ?>
          <?= $form->field($manufacturer, "[{$language_id}]description", [
            'template' => '{label}<div class="col-sm-10">{input}{error}</div>',
            'labelOptions' => [
                'class' => 'col-sm-2 control-label',
            ],
          ])->textArea(['class' => 'form-control summernote']) ?>
        </div>
        <?php
          ++$i;
        }?>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
