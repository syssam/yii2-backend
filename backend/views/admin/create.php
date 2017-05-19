<?php

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Admin */

$this->title = Yii::t('app', 'Create Admin');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('admin/index'),
  'text' => $this->title,
];

PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $model,
]);
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
<?php
PageForm::end();
?>
