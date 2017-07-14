<?php

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Park */

$this->title = Yii::t('app', 'Park');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('index'),
  'text' => $this->title,
];
PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $model,
  'panelTitle' => Yii::t('app', 'Edit Park'),
]);
?>

<?= $this->render('_form', [
    'zones' => $zones,
    'park_types' => $park_types,
    'manufacturers' => $manufacturers,
    'industry_types' => $industry_types,
    'park_to_industry_type' => $park_to_industry_type,
    'model' => $model,
    'attributes' => $attributes,
    'park_description' => $park_description,
    'park_attributes' => $park_attributes,
    'languages' => $languages,
]) ?>

<?php
 PageForm::end();
 ?>
