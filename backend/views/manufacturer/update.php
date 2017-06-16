<?php

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Admin */

$this->title = Yii::t('app', 'Manufacturers');

$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute(['index']),
  'text' => $this->title,
];

PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $model,
  'panelTitle' => 'Edit Manufacturer',
]);
echo $this->render('_form', [
    'model' => $model,
    'languages' => $languages,
    'manufacturer_description' => $manufacturer_description,
]);
PageForm::end();
