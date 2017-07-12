<?php

use backend\components\widgets\ActiveForm;
use yii\web\View;
use common\components\helpers\ImageHelper;
use yii\helpers\Html;

$model = isset($models[0]) ? $models[0] : $models;
$form = ActiveForm::begin([
    'id' => $model->formName(),
    'options' => [
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data',
    ],
  ]);
$formName = $model->formName();
foreach ($model->attributes() as $attribute) {
    $filed_name[$attribute] = '['.$attribute.']';
}
?>
  <table id="images" class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <td class="text-left"><?=$model->getAttributeLabel('title') ?></td>
        <td class="text-left" style="width:50%"><?=$model->getAttributeLabel('link')?></td>
        <td class="text-center"><?=$model->getAttributeLabel('image')?></td>
        <td class="text-right" style="width:10%"><?=$model->getAttributeLabel('sort_order')?></td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      <?php
      $image_row = 0;
      foreach ($models as $model) { ?>
      <tr id="image-row<?= $image_row; ?>">
        <?= $form->field($model, "[{$image_row}]title", [
          'template' => '<div class="input-group pull-left"><span class="input-group-addon"></span>{input}</div>{error}',
          'options' => [
            'tag' => 'td',
          ],
        ])->textInput() ?>
        <?= $form->field($model, "[{$image_row}]link", [
          'template' => '<div class="input-group pull-left"><span class="input-group-addon"></span>{input}</div>{error}',
          'options' => [
            'tag' => 'td',
          ],
        ])->textInput() ?>
        <?= $form->field($model, "[{$image_row}]image", [
          'template' => '{input}{error}',
          'options' => [
            'tag' => 'td',
          ],
        ])->ImageInput() ?>
        <?= $form->field($model, "[{$image_row}]sort_order", [
          'template' => '<div class="input-group pull-left"><span class="input-group-addon"></span>{input}</div>{error}',
          'options' => [
            'tag' => 'td',
          ],
        ])->textInput() ?>
        <td class="text-left">
          <button type="button" onclick="$('#image-row<?=$image_row?>').remove();" data-toggle="tooltip" class="btn btn-danger">
            <i class="fa fa-minus-circle"></i>
          </button>
        </td>
      </tr>
      <?php
      ++$image_row;
      } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4"></td>
        <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Banner"><i class="fa fa-plus-circle"></i></button></td>
      </tr>
    </tfoot>
  </table>
<?php ActiveForm::end();
$placeholder = ImageHelper::resize('no_image.png', 100, 100);
$js = <<<JS
  var image_row = {$image_row};

  function addImage() {
    html  = '<tr id="image-row' + image_row + '">';
    html += '  <td class="text-left"><div class="input-group pull-left"><span class="input-group-addon"></span><input type="text" name="{$formName}[' + image_row + ']{$filed_name['title']}" class="form-control" /></div></td>';
    html += '  <td class="text-left"><div class="input-group pull-left"><span class="input-group-addon"></span><input type="text" name="{$formName}[' + image_row + ']{$filed_name['link']}" class="form-control" /></div></td>';
    html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="{$placeholder}" data-placeholder="{$placeholder}" /></a><input type="hidden" name="BannerImage[' + image_row + '][image]" id="input-image' + image_row + '" /></td>';
    html += '  <td class="text-right"><div class="input-group pull-left"><span class="input-group-addon"></span><input type="text" name="{$formName}[' + image_row + ']{$filed_name['sort_order']}"  class="form-control" /></div></td>';
    html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row + '\').remove();" data-toggle="tooltip" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';

    $('#images tbody').append(html);

    image_row++;
  }
JS;
$this->registerJs($js, View::POS_END);
?>
