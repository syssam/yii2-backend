<?php

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Zone */

$this->title = Yii::t('app', 'Zone');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('index'),
  'text' => $this->title,
];
PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $model,
  'panelTitle' => Yii::t('app', 'Edit Zone'),
]);
?>

<?= $this->render('_form', [
    'model' => $model,
    'zone_description' => $zone_description,
]) ?>

<?php
 PageForm::end();
 ?>
