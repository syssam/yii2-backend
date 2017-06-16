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
  'model' => $model,
  'panelTitle' => 'Edit Banner',
]);
?>
<?= $this->render('_form', [
    'model' => $model,
    'datas' => $datas,
    'errors' => $errors,
]) ?>
<?php
PageForm::end();
?>
