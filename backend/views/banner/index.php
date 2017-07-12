<?php

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Admin */

$this->title = Yii::t('app', 'Banners');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('banner/index'),
  'text' => $this->title,
];

PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => isset($models[0]) ? $models[0] : $models,
  'panelTitle' => 'Edit Banner',
]);
?>
<?= $this->render('_form', [
    'models' => $models,
]) ?>
<?php
PageForm::end();
?>
