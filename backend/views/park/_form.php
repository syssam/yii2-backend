<?php

use backend\components\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\Park */
/* @var $form backend\components\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin([
      'id' => $model->formName(),
    ]); ?>

    <ul class="nav nav-tabs" id="nav-tabs">
      <li><a href="#tab-general" data-toggle="tab">General</a></li>
      <li><a href="#tab-data" data-toggle="tab">Data</a></li>
      <li><a href="#tab-attribute" data-toggle="tab">Attribute</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane" id="tab-general">
        <ul class="nav nav-tabs" id="language">
          <?php foreach ($languages as $index => $language) { ?>
          <li><a href="#language<?=$language->language_id?>" data-toggle="tab" aria-expanded="true"><img src="<?=Url::to('@web/image/').$language->image?>" title="<?=$language->name?>"> <?=$language->name?></a></li>
          <?php } ?>
        </ul>
        <div class="tab-content">
          <?php foreach ($park_description as $language_id => $park) { ?>
          <div class="tab-pane" id="language<?=$language_id?>">
            <?= $form->field($park, "[{$language_id}]name")->textInput() ?>
            <?= $form->field($park, "[{$language_id}]address")->textInput() ?>
            <?= $form->field($park, "[{$language_id}]video")->textInput() ?>
            <?= $form->field($park, "[{$language_id}]owner")->textInput() ?>
            <?= $form->field($park, "[{$language_id}]description")->EditorInput() ?>
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="tab-pane" id="tab-data">

        <?= $form->field($model, 'location_id')->dropDownList($zones, [
            'prompt' => 'Select Zone',
          ]) ?>

        <?= $form->field($model, 'park_type_id')->dropDownList($park_types, [
            'prompt' => 'Select Park Type',
          ]) ?>

        <?= $form->field($model, 'manufacturer_id')->dropDownList($manufacturers, [
            'prompt' => 'Select Manufacturer',
          ]) ?>

        <?= $form->field($park_to_industry_type, 'industry_type_id')->checkboxList($industry_types) ?>

        <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList([
          $model::STATUS_DELETED => 'Disabled',
          $model::STATUS_ACTIVE => 'Enabled',
        ]) ?>

        <?= $form->field($model, 'sort_order')->textInput() ?>
      </div>
      <div class="tab-pane" id="tab-attribute">
        <?php foreach ($park_attributes as $key => $attribute) { ?>
          <?= $form->field($attribute, "text")->langInput([
              'index' => $key,
            ])->label($attributes[$key]->attributeDescription->name); ?>
        <?php } ?>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
<?php
$js = <<<JS
  $('#nav-tabs a:first').tab('show');
  $('#language a:first').tab('show');
JS;
$this->registerJs($js, View::POS_END);
?>
