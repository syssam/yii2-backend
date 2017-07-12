<?php

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Tag */

$this->title = Yii::t('app', 'Tag');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('index'),
  'text' => $this->title,
];

PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $model,
  'panelTitle' => Yii::t('app', 'Create Tag'),
]);
?>

<?= $this->render('_form', [
    'model' => $model,
    'tag_description' => $tag_description,
]) ?>

<?php
 PageForm::end();
 ?>
