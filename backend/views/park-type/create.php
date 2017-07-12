<?php

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ParkType */

$this->title = Yii::t('app', 'Park Type');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('index'),
  'text' => $this->title,
];

PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $model,
  'panelTitle' => Yii::t('app', 'Create Park Type'),
]);
?>

<?= $this->render('_form', [
    'model' => $model,
    'park_type_description' => $park_type_description,
]) ?>

<?php
 PageForm::end();
 ?>
