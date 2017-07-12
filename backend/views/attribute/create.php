<?php

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Attribute */

$this->title = Yii::t('app', 'Attribute');

$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('index'),
  'text' => $this->title,
];

PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $model,
  'panelTitle' => Yii::t('app', 'Create Attribute'),
]);
?>

<?= $this->render('_form', [
    'model' => $model,
    'attribute_description' => $attribute_description,
]) ?>

<?php
 PageForm::end();
 ?>
