<?php

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\IndustryType */

$this->title = Yii::t('app', 'Industry Type');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('index'),
  'text' => $this->title,
];
PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $model,
  'panelTitle' => Yii::t('app', 'Edit Industry Type'),
]);
?>

<?= $this->render('_form', [
    'model' => $model,
    'industry_type_description' => $industry_type_description,
]) ?>

<?php
 PageForm::end();
 ?>
