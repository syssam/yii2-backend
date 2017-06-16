<?php

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Manufacturer */

$this->title = Yii::t('app', 'Create Manufacturer');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('index'),
  'text' => $this->title,
];

PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $model,
  'panelTitle' => 'Create Manufacturer',
]);
?>
<?= $this->render('_form', [
    'model' => $model,
    'languages' => $languages,
    'manufacturer_description' => $manufacturer_description,
]) ?>
<?php
PageForm::end();
?>
